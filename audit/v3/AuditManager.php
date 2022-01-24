<?php
namespace Audit\V3;

/**
 * класс AuditManager теперь
 * возвращает команду создания побочного эффекта, которую он хочет выполнить.
 */
class AuditManager
{
    private int $_maxEntriesPerFile;
    private int $_defaultMaxEntriesPerFile = 3;

    /**
     * @param int|null $maxEntriesPerFile
     */
    public function __construct(int $maxEntriesPerFile = null)
    {
        if (null !== $maxEntriesPerFile && $maxEntriesPerFile < 1) {
            throw new \LogicException('Parameter $maxEntriesPerFile: cannot be less than 1.');
        }
        $this->_maxEntriesPerFile = $maxEntriesPerFile ?: $this->_defaultMaxEntriesPerFile;
    }

    /**
     * @param FileCollection $collection
     * @param string $visitorName
     * @param \DateTime $timeOfVisit
     * @return FileUpdate
     */
    public function addRecord(FileCollection $collection, string $visitorName, \DateTime $timeOfVisit): FileUpdate
    {
        $newRecord = [
            $visitorName ." ". $timeOfVisit->format('Y-m-d H:i:s') . PHP_EOL
        ];
        if( $collection->length() == 0 ) {

           return new FileUpdate('audit_0.txt', $newRecord);
        }

        $lastFile = $collection->getLastFile();
        if ( $lastFile->countLines() < $this->_maxEntriesPerFile ) {

            return new FileUpdate($lastFile->getFileName(), $lastFile->getLines());
        }
        else {
            $numFile = (int)preg_replace('/[^0-9]/', '', $lastFile->getFileName());
            $newName = "audit_".++$numFile.".txt";

            return new FileUpdate($newName, $newRecord);
        }
    }

    /**
     * @return int
     */
    public function getMaxEntriesPerFile(): int
    {
        return $this->_maxEntriesPerFile;
    }

    /**
     * @return string
     */
    public function getDirectoryPath(): string
    {
        return $this->_directoryPath;
    }

}