<?php
/**
 * Date: 12.01.2021
 * Time: 20:55
 */

namespace App\Utils;


class Config
{
    const CONFIG_FILE = __DIR__ . '/../../.env';

    public static function get(string $key): string
    {
        $array = (file_exists(self::CONFIG_FILE))
            ? file(self::CONFIG_FILE, FILE_IGNORE_NEW_LINES)
            : [];

        foreach ($array as $item) {
            $strArr = explode(':', $item);
            if ($strArr[0] == $key) {
                return trim($strArr[1]);
            } else {
                continue;
            }
        }
    }
}