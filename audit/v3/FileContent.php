<?php

namespace Audit\V3;

class FileContent
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

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->_fileName;
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->_lines;
    }

}