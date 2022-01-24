<?php

namespace Audit\V3;

use Audit\V3\Interfaces\Item;

class FileUpdate implements Item
{
    private string $_fileName;
    private array $_content;

    /**
     * @param string $fileName
     * @param array $content
     */
    public function __construct(string $fileName, array $content)
    {
        $this->_fileName = $fileName;
        $this->_content = $content;
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
    public function getContent(): array
    {
        return $this->_content;
    }


}