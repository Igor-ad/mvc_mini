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
        $data = (file_get_contents(self::CONFIG_FILE))
            ? file_get_contents(self::CONFIG_FILE)
            : '';

        $array = explode("\n", $data);
        foreach ($array as $item) {
            $keyStr = strstr($item, ': ', true);
            if ($keyStr == $key) {
                return trim(strstr($item, ' '));
            } else {
                continue;
            }
        }
    }
}