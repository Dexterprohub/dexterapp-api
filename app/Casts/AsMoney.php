<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsMoney implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ?string
    {
        $value ??= 0;

        return format_money($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        $value ??= 0;

        return parse_money($value);
    }
}
