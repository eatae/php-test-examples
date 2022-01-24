<?php

namespace Audit\V3;

use Audit\V3\Interfaces\Item;

class FileContent implements Item
{
    private string $_fileName;
    private array $_lines;

    /**
     * @param string $fileName
     * @param array $lines
     */
    public function __construct(string $fileName, array $lines)
    {
        $this->_fileName = $fileName;
        $this->_lines = $lines;
    }

    public function getFileName(): string
    {
        return $this->_fileName;
    }

    public function getLines(): array
    {
        return $this->_lines;
    }

    public function setLine(string $line): void
    {
        array_push($this->_lines, $line);
    }

    public function countLines(): int
    {
        return count($this->_lines);
    }

}