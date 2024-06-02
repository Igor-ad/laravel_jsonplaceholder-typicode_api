<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Geo extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'geo';

    public $timestamps = false;

    protected $fillable = [
        'lat',
        'lng',
        'user_id',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'user_id', 'user_id');
    }
}
