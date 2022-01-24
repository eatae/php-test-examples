<?php

namespace Audit\V3;

class ApplicationService
{
    private string $_directoryPath;
    private AuditManager $_auditManager;
    private Persister $_persister;

    /**
     * @param AuditManager $auditManager
     * @param Persister $persister
     */
    public function __construct(AuditManager $auditManager, Persister $persister)
    {
        $this->_directoryPath = realpath(__DIR__."/../data");
        $this->_auditManager = $auditManager;
        $this->_persister = $persister;
    }

    public function addRecord(string $visitorName, \DateTime $timeOfVisit)
    {
        $fileCollection = $this->_persister->readDirectory(
            $this->_directoryPath,
            new FileCollection(new FileContentSpecifier())
        );
        /** @var FileUpdate $fileUpdate */
        $fileUpdate = $this->_auditManager->addRecord(
            $fileCollection, $visitorName,
            $timeOfVisit
        );
        $this->_persister->applyUpdate($this->_directoryPath, $fileUpdate);
    }
}