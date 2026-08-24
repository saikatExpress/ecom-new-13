<?php

namespace App\Helpers\Courier;

class EnvHelper
{
    public static function update(array $values): void
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            throw new \RuntimeException('.env file not found.');
        }

        $env = file_get_contents($envPath);

        foreach ($values as $key => $value) {

            $value = self::formatValue($value);

            $pattern = "/^" . preg_quote($key, '/') . "=.*$/m";

            if (preg_match($pattern, $env)) {

                $env = preg_replace($pattern,"{$key}={$value}",$env);

            } else {

                $env .= PHP_EOL . "{$key}={$value}";
            }
        }

        file_put_contents($envPath, $env);
    }

    protected static function formatValue($value): string
    {
        if ($value === null) {
            return '';
        }

        $value = (string) $value;

        if (str_contains($value, ' ') || str_contains($value, '#') || str_contains($value, '"')) {
            return '"' . addslashes($value) . '"';
        }

        return $value;
    }
}
