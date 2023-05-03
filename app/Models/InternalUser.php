<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InternalUser
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $username
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\InternalUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternalUser whereUsername($value)
 * @mixin \Eloquent
 */
class InternalUser extends Model
{
    use HasFactory;
}
