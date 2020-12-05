<?php

use ktamas77\phptimer\Timer;
use PHPUnit\Framework\TestCase;

class PHPTimerTest extends TestCase
{
    private $timer;

    public function setUp(): void
    {
        parent::setUp();
        $this->timer = new Timer();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->timer);
    }

    public function testDefaultMask(): void
    {
        self::assertEquals('%01.2f', $this->timer->getTimerMask());
    }

    public function testSetAndGetTimerMask(): void
    {
        $this->timer->setTimerMask('hello');
        self::assertEquals('hello', $this->timer->getTimerMask());
    }

    public function testStartAndStop(): void
    {
        $this->timer->start('testlabel');
        sleep(1);
        $this->timer->stop('testlabel');
        $result = $this->timer->get('testlabel');
        self::assertLessThan($result['stop'], $result['start']);
        self::assertGreaterThanOrEqual(1, $result['range']);
        self::assertEquals('stopped', $result['status']);
        self::assertEquals('1.00', $result['average_human']);
        self::assertEquals('1.00', $result['range_human']);
    }

    public function testDeleteTimer(): void
    {
        $this->timer->start('testlabel');
        $this->timer->stop('testlabel');
        $this->timer->del('testlabel');
        self::assertFalse($this->timer->get('testlabel'));
    }

    public function testNonExistingTimer(): void
    {
        self::assertFalse($this->timer->get('testlabelrandom'));
    }
}