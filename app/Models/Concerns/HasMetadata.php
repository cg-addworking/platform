<?php

namespace App\Models\Concerns;

use ArrayAccess;

trait HasMetadata
{
    protected $metadataAttribute = "metadata";

    protected static function bootHasMetadata()
    {
        static::saving(function ($model) {
            if (!empty($model->attributes[$model->metadataAttribute])) {
                $model->{$model->metadataAttribute} = json_encode($model->attributes[$model->metadataAttribute]);
            }
        });
    }

    public function meta($key, $default = null)
    {
        return $this->metadata()->get($key, $default);
    }

    public function metadata()
    {
        $data = &$this->attributes[$this->metadataAttribute];

        /**
         * @todo fixme!
         */
        while (is_string($data)) {
            $data = json_decode($data, true);
        }

        return new class($data) implements ArrayAccess
        {
            protected $data;

            public function __construct(&$data)
            {
                $this->data = &$data;
            }

            public function __isset($key)
            {
                return $this->has($key);
            }

            public function __get($key)
            {
                return $this->get($key);
            }

            public function __set($key, $value)
            {
                return $this->set($key, $value);
            }

            public function __unset($key)
            {
                return $this->pull($key);
            }

            public function has($key)
            {
                return array_has($this->data, $key);
            }

            public function get($key, $default = null)
            {
                return array_get($this->data, $key, $default);
            }

            public function set($key, $value)
            {
                array_set($this->data, $key, $value);
            }

            public function add($key, $value)
            {
                $this->data = array_add($this->data, $key, $value);
            }

            public function pull($key, $default = null)
            {
                return array_pull($this->data, $key, $default);
            }

            public function offsetExists($offset)
            {
                return $this->has($offset);
            }

            public function offsetGet($offset)
            {
                return $this->get($offset);
            }

            public function offsetSet($offset, $value)
            {
                return $this->set($offset, $value);
            }

            public function offsetUnset($offset)
            {
                $this->pull($offset);
            }
        };
    }

    public function getFillable()
    {
        if (!in_array($this->metadataAttribute, $fillable = parent::getFillable())) {
            $fillable[] = $this->metadataAttribute;
        }

        return $fillable;
    }

    public function getCasts()
    {
        if (!array_key_exists($this->metadataAttribute, $casts = parent::getCasts())) {
            $casts[$this->metadataAttribute] = 'json';
        }

        return $casts;
    }
}
