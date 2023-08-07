<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    // Define the fillable columns that can be mass-assigned
    protected $fillable = [
        'iso',
        'name',
        'iso3',
        'currency_code',
        'currency_name',
        'exchange_rate',
        'numcode',
        'phonecode',
        'flag',
    ];

    // Accessors
    public function getCurrencyExchangeAttribute()
    {
        return number_format($this->exchange_rate, 2);
    }

    // Mutators
    public function setPhonecodeAttribute($value)
    {
        // Remove any existing "+" symbol from the phonecode
        $value = ltrim($value, '+');

        // Add the "+" symbol back to the phonecode before saving it
        $this->attributes['phonecode'] = '+'.$value;
    }
}
