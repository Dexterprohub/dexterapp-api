<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MenuItemExtra
 *
 * @property int $id
 * @property int $menu_item_id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $image
 * @property int $order_index
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MenuItem $menuItem
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra whereMenuItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra whereOrderIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemExtra whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuItemExtra extends Model
{
    use HasFactory;
    public function menuItem(){
        return $this->belongsTo(MenuItem::class);
    }
}
