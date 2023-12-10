<?php
namespace App\Services;

use App\Helper\Util;

class FileProcessorService {
    public function processFile($file)
    {
        $json = Util::getJsonFileContent($file);

        dd($json);
    }
}
