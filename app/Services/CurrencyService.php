<?php

namespace App\Services;

class CurrencyService
{
    /**
     * Get currency symbol for given currency code
     */
    public static function getSymbol(string $currencyCode): string
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'CHF' => 'CHF',
            'CNY' => '¥',
            'INR' => '₹',
            'NGN' => '₦',
        ];

        return $symbols[$currencyCode] ?? $currencyCode;
    }

    /**
     * Get currency name for given currency code
     */
    public static function getName(string $currencyCode): string
    {
        $names = [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'JPY' => 'Japanese Yen',
            'CAD' => 'Canadian Dollar',
            'AUD' => 'Australian Dollar',
            'CHF' => 'Swiss Franc',
            'CNY' => 'Chinese Yuan',
            'INR' => 'Indian Rupee',
            'NGN' => 'Nigerian Naira',
        ];

        return $names[$currencyCode] ?? $currencyCode;
    }

    /**
     * Get all supported currencies with symbols and names
     */
    public static function getAllCurrencies(): array
    {
        return [
            'USD' => ['symbol' => '$', 'name' => 'US Dollar'],
            'EUR' => ['symbol' => '€', 'name' => 'Euro'],
            'GBP' => ['symbol' => '£', 'name' => 'British Pound'],
            'JPY' => ['symbol' => '¥', 'name' => 'Japanese Yen'],
            'CAD' => ['symbol' => 'C$', 'name' => 'Canadian Dollar'],
            'AUD' => ['symbol' => 'A$', 'name' => 'Australian Dollar'],
            'CHF' => ['symbol' => 'CHF', 'name' => 'Swiss Franc'],
            'CNY' => ['symbol' => '¥', 'name' => 'Chinese Yuan'],
            'INR' => ['symbol' => '₹', 'name' => 'Indian Rupee'],
            'NGN' => ['symbol' => '₦', 'name' => 'Nigerian Naira'],
        ];
    }

    /**
     * Format amount with currency symbol
     */
    public static function format(float $amount, string $currencyCode): string
    {
        $symbol = self::getSymbol($currencyCode);
        return $symbol . ' ' . number_format($amount, 2);
    }

    /**
     * Format amount with currency code (for display)
     */
    public static function formatWithCode(float $amount, string $currencyCode): string
    {
        return $currencyCode . ' ' . number_format($amount, 2);
    }
}
