<?php
namespace Audit\V1;

class AuditManager
{
    private int $_maxEntriesPerFile;
    private string $_directoryPath;
    private string $_defaultDirectoryPath;


    public function __construct(?int $maxEntriesPerFile = null, ?string $directoryPath = null)
    {
        $this->_defaultDirectoryPath = realpath(__DIR__."/../data");
        if (null !== $maxEntriesPerFile && $maxEntriesPerFile < 1) {
            throw new \LogicException('Parameter $maxEntriesPerFile: cannot be less than 1.');
        }
        if (null !== $directoryPath && !realpath($directoryPath)) {
            throw new \LogicException('Parameter $directoryPath: must be a directory.');
        }
        $this->_maxEntriesPerFile = $maxEntriesPerFile ?: 3;
        $this->_directoryPath = realpath($directoryPath) ?: $this->_defaultDirectoryPath;
    }


    public function getMaxEntriesPerFile(): int
    {
        return $this->_maxEntriesPerFile;
    }

    public function getDirectoryPath(): string
    {
        return $this->_directoryPath;
    }

    public function getDefaultDirectoryPath(): string
    {
        return $this->_defaultDirectoryPath;
    }

}