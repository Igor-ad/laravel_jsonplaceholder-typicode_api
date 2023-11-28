<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Geo extends Model
{
    use HasFactory, SoftDeletes, ModelHelperTrait;

    public $table = 'geo';

    public $timestamps = false;

    protected $fillable = [
        'lat',
        'lng',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
        'deleted_at',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'user_id', 'user_id');
    }
}
