<?php
namespace Audit\V3;

class AuditManager
{
    private int $_maxEntriesPerFile;
    private string $_directoryPath;
    private IFileSystem $_fileSystem;

    private string $_defaultDirectoryPath;
    private int $_defaultMaxEntriesPerFile = 3;


    public function __construct(int $maxEntriesPerFile = null)
    {
        if (null !== $maxEntriesPerFile && $maxEntriesPerFile < 1) {
            throw new \LogicException('Parameter $maxEntriesPerFile: cannot be less than 1.');
        }

        $this->_maxEntriesPerFile = $maxEntriesPerFile ?: $this->_defaultMaxEntriesPerFile;
    }


    public function addRecord(array $files, string $visitorName, \DateTime $timeOfVisit): FileUpdate
    {
        sort($files);
        $newRecord = [
            $visitorName ." ". $timeOfVisit->format('Y-m-d H:i:s') . PHP_EOL
        ];

        if( count($files) == 0 ) {

            return new FileUpdate('audit_0.txt', $newRecord);
        }

        $currentFile = array_pop($files);
        $lines = $currentFile->getLines();

        if ( count($lines) < $this->_maxEntriesPerFile ) {
            array_push($lines, $newRecord);

            return new FileUpdate($currentFile->getFileName(), $lines);
        }
        else {
            $numFile = (int)preg_replace('/[^0-9]/', '', $currentFile->getFileName());
            $newName = "/audit_".++$numFile.".txt";

            return new FileUpdate($newName, $newRecord);
        }
    }





    public function addRecord_old(string $visitorName, \DateTime $timeOfVisit)
    {
        $files = $this->_fileSystem->getFiles( $this->_directoryPath );
        sort($files);
        $newRecord = $visitorName ." ". $timeOfVisit->format('Y-m-d H:i:s') . PHP_EOL;

        if( count($files) == 0 ) {
            $newFilePath = $this->_directoryPath."/audit_0.txt";
            $this->_fileSystem->fileWrite($newFilePath, $newRecord);
            return;
        }

        $lastFileName = array_pop($files);
        $lastFilePath = $this->getDirectoryPath() ."/".$lastFileName;

        if ( count($this->_fileSystem->fileRead($lastFilePath)) < $this->getMaxEntriesPerFile() ) {
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