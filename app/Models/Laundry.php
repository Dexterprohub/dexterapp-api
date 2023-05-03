<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Laundry
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Laundry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laundry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laundry query()
 * @method static \Illuminate\Database\Eloquent\Builder|Laundry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laundry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laundry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Laundry extends Model
{
    use HasFactory;
}
