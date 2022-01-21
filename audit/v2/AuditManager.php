<?php
namespace Audit\V2;

class AuditManager
{
    private int $_maxEntriesPerFile;
    private string $_directoryPath;
    private IFileSystem $_fileSystem;

    private string $_defaultDirectoryPath;
    private int $_defaultMaxEntriesPerFile = 3;


    public function __construct(IFileSystem $fileSystem, ?int $maxEntriesPerFile = null, ?string $directoryPath = null)
    {
        $this->_defaultDirectoryPath = realpath(__DIR__."/../data");
        $this->_fileSystem = $fileSystem;

        if (null !== $maxEntriesPerFile && $maxEntriesPerFile < 1) {
            throw new \LogicException('Parameter $maxEntriesPerFile: cannot be less than 1.');
        }
        if (null !== $directoryPath && !is_dir($directoryPath)) {
            throw new \LogicException('Parameter $directoryPath: must be a directory or null.');
        }

        $this->_maxEntriesPerFile = $maxEntriesPerFile ?: $this->_defaultMaxEntriesPerFile;
        $this->_directoryPath = is_dir($directoryPath) ? realpath($directoryPath) : $this->_defaultDirectoryPath;
    }



    public function addRecord(string $visitorName, \DateTime $timeOfVisit)
    {
        $files = $this->_fileSystem->getFiles( $this->getDirectoryPath() );
        sort($files);
        $newRecord = $visitorName ." ". $timeOfVisit->format('Y-m-d H:i:s') . PHP_EOL;

        if( count($files) == 0 ) {
            $newFilePath = $this->getDirectoryPath()."/audit_0.txt";
            $this->_fileSystem->fileWrite($newFilePath, $newRecord);

            return;
        }

        $lastFileName = array_pop($files);
        $lastFilePath = $this->getDirectoryPath() ."/".$lastFileName;

        if ( sizeof(file($lastFilePath)) < $this->getMaxEntriesPerFile() ) {
            $this->_fileSystem->fileWrite($lastFilePath, $newRecord);
        }
        else {
            $numFile = (int)preg_replace('/[^0-9]/', '', $lastFileName);
            $newFilePath = $this->getDirectoryPath()."/audit_".++$numFile.".txt";

            $this->_fileSystem->fileWrite($newFilePath, $newRecord);
        }

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

    public function getDefaultMaxEntriesPerFile(): string
    {
        return $this->_defaultMaxEntriesPerFile;
    }

    public function getFileSystem(): IFileSystem
    {
        return $this->_fileSystem;
    }

}