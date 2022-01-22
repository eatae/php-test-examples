<?php

namespace Audit\V3;

class Persister
{
    public function readDirectory(string $directoryPath): array
    {
        $files = [];
        $listFiles = array_diff(scandir($directoryPath), array('..', '.'));
        foreach ($listFiles as $fileName) {
            $content = file($directoryPath."/".$fileName);
            $files[] = new FileContent($fileName, $content);
        }
        return $files;
    }

    public function applyUpdate(string $directoryPath, FileUpdate $fileUpdate): void
    {
        $pathToFile = $directoryPath."/".$fileUpdate->getFileName();
        $file = fopen($pathToFile, "a") or die("Unable to open file!");
        fwrite($file, implode('', $fileUpdate->getContent()));
        fclose($file);
    }
}