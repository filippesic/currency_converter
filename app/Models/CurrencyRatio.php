<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRatio extends Model
{
    use HasFactory;

    protected $fillable = ['ratio', 'api_timestamp'];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
