<?php

if (!function_exists('currency_symbol')) {
    /**
     * Get currency symbol for given currency code
     */
    function currency_symbol(string $currencyCode): string
    {
        return \App\Services\CurrencyService::getSymbol($currencyCode);
    }
}

if (!function_exists('currency_name')) {
    /**
     * Get currency name for given currency code
     */
    function currency_name(string $currencyCode): string
    {
        return \App\Services\CurrencyService::getName($currencyCode);
    }
}

if (!function_exists('currency_format')) {
    /**
     * Format amount with currency symbol
     */
    function currency_format(float $amount, string $currencyCode): string
    {
        return \App\Services\CurrencyService::format($amount, $currencyCode);
    }
}

if (!function_exists('currency_format_with_code')) {
    /**
     * Format amount with currency code
     */
    function currency_format_with_code(float $amount, string $currencyCode): string
    {
        return \App\Services\CurrencyService::formatWithCode($amount, $currencyCode);
    }
}

if (!function_exists('get_all_currencies')) {
    /**
     * Get all supported currencies
     */
    function get_all_currencies(): array
    {
        return \App\Services\CurrencyService::getAllCurrencies();
    }
}
