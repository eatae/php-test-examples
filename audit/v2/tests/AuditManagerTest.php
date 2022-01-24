<?php
namespace Audit\V2\Tests;

use Audit\V2\AuditManager;
use Audit\V2\FileSystem;
use Audit\V2\IFileSystem;
use PHPUnit\Framework\TestCase;

class AuditManagerTest extends TestCase
{
    protected IFileSystem $fileSystemStub;

    protected function setUp(): void
    {
        $this->fileSystemStub = $this->createMock(FileSystem::class);
    }

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
        $sut = new AuditManager($this->fileSystemStub);

        $this->assertEquals($sut->getDefaultMaxEntriesPerFile(), $sut->getMaxEntriesPerFile());
        $this->assertEquals($sut->getDefaultDirectoryPath(), $sut->getDirectoryPath());
    }

    public function testConstructor_BadMaxEntriesPerFile()
    {
        $maxEntriesPerFile = -1;

        $this->expectException(\LogicException::class);
        $sut = new AuditManager($this->fileSystemStub, $maxEntriesPerFile);
        var_dump($sut->getMaxEntriesPerFile());
    }

    public function testConstructor_BadDirectoryPath()
    {
        $maxEntriesPerFile = 3;
        $directoryPath = __DIR__."/foo";

        $this->expectException(\LogicException::class);
        $sut = new AuditManager($this->fileSystemStub, $maxEntriesPerFile, $directoryPath);
        var_dump($sut->getDirectoryPath());
    }



    public function testAddRecord_CreateNewFileAfterOverflow()
    {
        // создаём mock и указываем методы, которые будем дальше настраивать
        $fileSystemMock = $this->getMockBuilder(FileSystem::class)
            ->onlyMethods(['fileWrite', 'getFiles', 'fileRead'])
            ->getMock();

        // настраиваем метод getFiles
        $fileSystemMock->method('getFiles')->willReturn([
            "audit_1.txt",
            "audit_2.txt"
        ]);

        // настраиваем метод fileRead
        $fileSystemMock->method('fileRead')->willReturn([
            "Peter 2022-01-21 17:29:11",
            "Jane 2022-01-21 17:30:22",
            "Jack 2022-01-21 17:32:33",
        ]);

        // sut
        $sut = new AuditManager($fileSystemMock);
        // Ожидаем вызов метода mock fileWrite() с определенными параметрами
        // и всё нам не нужно теперь использовать в тесте реальную работу с файловой системой
        $fileSystemMock->expects($this->once())->method('fileWrite')
            ->with(
                $sut->getDirectoryPath()."/audit_3.txt",
                "Alice 2022-01-21 18:40:00".PHP_EOL)
        ;

        $sut->addRecord("Alice", new \DateTime('2022-01-21 18:40:00'));
    }


}