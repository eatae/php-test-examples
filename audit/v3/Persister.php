<?php

namespace Audit\V3;

class Persister
{
    public function readDirectory(string $directoryPath, FileCollection $collection): FileCollection
    {
        if (! $collection->isEmpty()) {
            throw new \Exception("Collection must be empty.");
        }
        $listFiles = array_diff(scandir($directoryPath), array('..', '.'));
        foreach ($listFiles as $fileName) {
            $content = file($directoryPath."/".$fileName);
            $collection->addItem(new FileContent($fileName, $content));
        }
        return $collection;
    }

    public function applyUpdate(string $directoryPath, FileUpdate $fileUpdate): void
    {
        $pathToFile = $directoryPath."/".$fileUpdate->getFileName();
        $file = fopen($pathToFile, "a") or die("Unable to open file!");
        fwrite($file, implode('', $fileUpdate->getContent()));
        fclose($file);
    }
}