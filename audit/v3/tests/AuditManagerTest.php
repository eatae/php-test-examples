<?php
namespace Audit\V3\Tests;

use Audit\V3\AuditManager;
use Audit\V3\FileCollection;
use Audit\V3\FileContent;
use Audit\V3\FileContentSpecifier;
use Audit\V3\FileSystem;
use Audit\V3\Interfaces\FileSystem as FS;
use Audit\V3\Persister;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;

class AuditManagerTest extends TestCase
{
    /**
     * Debug SKIPPED
     */
    public function testDebug()
    {
        $sut = new AuditManager();

        $this->markTestSkipped();
    }

    public function testAddRecord_CreateNewFileAfterOverflow()
    {
        $sut = new AuditManager();
        $files = new FileCollection(new FileContentSpecifier());
        $files->addItem(new FileContent('audit_0.txt', []));
        $files->addItem(new FileContent('audit_1.txt', [
            "Peter 2022-01-21 17:29:11",
            "Jane 2022-01-21 17:30:22",
            "Jack 2022-01-21 17:32:33",
        ]));

        $fileUpdate = $sut->addRecord(
            $files,
            'Alice',
            new \DateTime('2022-01-24 20:00:00')
        );

        $this->assertEquals("audit_2.txt", $fileUpdate->getFileName());
        $this->assertEquals(['Alice 2022-01-24 20:00:00'.PHP_EOL], $fileUpdate->getContent());
    }
}