<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\SoftDeletes;

trait HasNumber
{
    /**
     * The local attribute holding the number
     *
     * @var string
     */
    protected $numberAttribute = 'number';

    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootHasNumber()
    {
        static::creating(function ($model) {
            $model->{$model->numberAttribute} = $model->getNextNumber();
        });
    }

    /**
     * Get the next number to assign.
     *
     * @return integer
     */
    public function getNextNumber()
    {
        if (in_array(SoftDeletes::class, class_uses($this))) {
            return ($this->withTrashed()->max($this->numberAttribute) ?: 0) + 1;
        }

        return ($this->max($this->numberAttribute) ?: 0) + 1;
    }

    /**
     * Gets a models from its number.
     *
     * @param  mixed $number
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function fromNumber($number): self
    {
        return static::where((new self)->numberAttribute, $number)->firstOrFail();
    }
}
