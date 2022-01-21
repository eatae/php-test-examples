<?php
namespace Audit\V2\Tests;

use Audit\V1\AuditManager;
use Audit\V2\FileSystem;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;

class AuditManagerTest extends TestCase
{

    /**
     * Debug SKIPPED
     */
    public function testDebug()
    {
        //$sut = new AuditManager();

        // addRecord
        //$sut->addRecord('DebugVisitor', new \DateTime);

        // constructor
        //var_dump(realpath($sut->getDirectoryPath()));

        $this->markTestSkipped();
    }


    public function testConstructor()
    {
        $sut = new AuditManager();

        $this->assertEquals($sut->getDefaultMaxEntriesPerFile(), $sut->getMaxEntriesPerFile());
        $this->assertEquals($sut->getDefaultDirectoryPath(), $sut->getDirectoryPath());
    }

    public function testConstructor_BadMaxEntriesPerFile()
    {
        $maxEntriesPerFile = -1;

        $this->expectException(\LogicException::class);
        $sut = new AuditManager($maxEntriesPerFile);
        var_dump($sut->getMaxEntriesPerFile());
    }

    public function testConstructor_BadDirectoryPath()
    {
        $maxEntriesPerFile = 3;
        $directoryPath = __DIR__."/foo";

        $this->expectException(\LogicException::class);
        $sut = new AuditManager($maxEntriesPerFile, $directoryPath);
        var_dump($sut->getDirectoryPath());
    }


    public function testAddRecord_CreateNewFileAfterOverflow()
    {
        $fileSystemMock = $this->getMockBuilder(FileSystem::class);

    }


}