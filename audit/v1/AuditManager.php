<?php
namespace Audit\V1;

class AuditManager
{
    private int $_maxEntriesPerFile;
    private string $_directoryPath;
    private string $_defaultDirectoryPath;
    private int $_defaultMaxEntriesPerFile = 3;


    public function __construct(?int $maxEntriesPerFile = null, ?string $directoryPath = null)
    {
        $this->_defaultDirectoryPath = realpath(__DIR__."/../data");

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
        $files = array_diff(scandir($this->getDirectoryPath()), array('..', '.'));
        sort($files);
        $newRecord = $visitorName ." ". $timeOfVisit->format('Y-m-d H:i:s') . PHP_EOL;

        if( count($files) == 0 ) {
            $newFile = fopen($this->getDirectoryPath()."/audit_0.txt", "w") or die("Unable to open file!");
            fwrite($newFile, $newRecord);
            fclose($newFile);

            return;
        }

        $lastFileName = array_pop($files);
        $lastFilePath = $this->getDirectoryPath() ."/".$lastFileName;

        if ( sizeof(file($lastFilePath)) < $this->getMaxEntriesPerFile() ) {
            $file = fopen($lastFilePath, "a+") or die("Unable to open file!");
            fwrite($file, $newRecord);
            fclose($file);
        }
        else {
            $numFile = (int)preg_replace('/[^0-9]/', '', $lastFileName);
            $newFileName = $this->getDirectoryPath()."/audit_".++$numFile.".txt";

            $newFile = fopen( $newFileName, "w") or die("Unable to open file!");
            fwrite($newFile, $newRecord);
            fclose($newFile);
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

}