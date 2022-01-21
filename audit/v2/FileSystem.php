<?php

namespace Audit\V2;

class FileSystem implements IFileSystem
{

    public function getFiles(string $dir): array
    {
        return array_diff(scandir($dir), array('..', '.'));
    }

    public function fileWrite(string $filePath, string $content): void
    {
        if (is_writable($filePath)) {
            $file = fopen($filePath, "w") or die("Unable to open file!");
        } else {
            $file = fopen($filePath, "a+") or die("Unable to open file!");
        }
        fwrite($file, $content);
        fclose($file);
    }

    public function fileRead(string $filePath): array
    {
        return file($filePath);
    }
}