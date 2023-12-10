<?php
namespace App\Helper;

class Util {
    public static function getJsonFileContent($content): array
    {
        $file = file_get_contents($content);
        return json_decode($file, true);
    }
}
