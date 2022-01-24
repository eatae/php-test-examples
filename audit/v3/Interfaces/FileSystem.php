<?php

namespace Audit\V3\Interfaces;

interface FileSystem
{
    public function getFiles(string $dir): array;

    public function fileWrite(string $filePath, string $content): void;

    public function fileRead(string $filePath): array;
}