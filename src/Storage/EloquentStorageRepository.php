<?php

namespace Farzai\ModelSettings\Storage;

use Farzai\ModelSettings\Contracts\Factory as FactoryContract;
use Farzai\ModelSettings\Contracts\Setting as SettingContract;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection;

class EloquentStorageRepository implements FactoryContract, SettingContract
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|string  $model
     */
    public function __construct($model)
    {
        if (is_string($model)) {
            $model = new $model;
        }

        $this->query = clone ($model instanceof EloquentModel
            ? $model->query()
            : $model);
    }

    /**
     * Create a new Setting instance from the given model.
     */
    public function for($model): SettingContract
    {
        if (is_string($model)) {
            $model = new $model;

            $settingModelName = config('model-settings.model');
            $settingModel = new $settingModelName;

            $query = $settingModel->newQuery()->where('model_type', $model->getMorphClass());

            return new EloquentStorageRepository(tap($query, function ($query) use ($model) {
                $settingModel = $query->getModel();
                $settingModel->fill([
                    'model_type' => $model->getMorphClass(),
                ]);
            }));
        }

        if (! method_exists($model, 'settings')) {
            throw new \InvalidArgumentException(sprintf(
                'The given model [%s] must have a settings relationship.',
                get_class($model)
            ));
        }

        return new EloquentStorageRepository(tap($model->settings(), function ($query) use ($model) {
            $settingModel = $query->getModel();
            $settingModel->fill([
                'model_id' => $model->getKey(),
                'model_type' => $model->getMorphClass(),
            ]);
        }));
    }

    /**
     * Get all settings.
     */
    public function all(): Collection
    {
        return $this->query->get()->mapWithKeys(function (EloquentModel $setting) {
            // Fix "Access to an undefinded property" error
            if (! isset($setting->key) || ! isset($setting->value)) {
                return [];
            }

            return [$setting->key => $setting->value];
        });
    }

    /**
     * Get the value of the given key.
     *
     * @param  mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $setting = $this->query->where('key', $key)->first();

        if ($setting) {
            // Fix "Access to an undefinded property" error
            if (! isset($setting->value)) {
                return $default;
            }

            if (null !== ($json = @json_decode($setting->value, true))) {
                return $json;
            }

            if ($setting->value === 'true') {
                return true;
            } elseif ($setting->value === 'false') {
                return false;
            }

            return $setting->value;
        }

        return $default;
    }

    /**
     * Set the value of the given key.
     *
     * @param  mixed  $value
     * @return void
     */
    public function set(string $key, $value)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        $model = $this->query->getModel();

        $model->fill([
            'key' => $key,
            'value' => $value,
        ])->save();
    }

    /**
     * Determine if the given key exists.
     */
    public function has(string $key): bool
    {
        return $this->query->where('key', $key)->exists();
    }

    /**
     * Remove the value of the given key.
     *
     * @return void
     */
    public function forget(string $key)
    {
        $this->query->where('key', $key)->delete();
    }

    /**
     * Remove all items from the storage.
     *
     * @return void
     */
    public function flush()
    {
        $this->all()->each->delete();
    }
}
