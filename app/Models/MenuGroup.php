<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MenuGroup
 *
 * @property int $id
 * @property int $menu_id
 * @property string $name
 * @property string $image
 * @property int $order_index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Menu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup whereOrderIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuGroup extends Model
{
    use HasFactory;

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}
