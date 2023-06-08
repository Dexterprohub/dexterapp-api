<?php

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

if (! function_exists('parse_money')) {
    function parse_money($amount, $currency = 'NGN'): string
    {
        $currencies = new ISOCurrencies();

        $moneyParser = new DecimalMoneyParser($currencies);

        return $moneyParser->parse($amount, new Currency($currency))->getAmount();
    }
}

if (! function_exists('format_money')) {
    function format_money($amount, $currency = 'NGN'): string
    {
        $currencies = new ISOCurrencies();

        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format(new Money($amount, new Currency($currency)));
    }
}

if (! function_exists('transform_money')) {
    function transform_money($amount, $currency = 'NGN'): string
    {
        return format_money(parse_money($amount, $currency), $currency);
    }
}
