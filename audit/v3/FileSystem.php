<?php

namespace Audit\V3;

use Audit\V3\Interfaces\FileSystem as FS;

class FileSystem implements FS
{

    public function getFiles(string $dir): array
    {
        return array_diff(scandir($dir), array('..', '.'));
    }

    public function fileWrite(string $filePath, string $content): void
    {
        $file = fopen($filePath, "a") or die("Unable to open file!");
        fwrite($file, $content);
        fclose($file);
    }

    public function fileRead(string $filePath): array
    {
        return file($filePath);
    }
}