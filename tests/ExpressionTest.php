<?php

namespace PE\Component\Cronos\Expression\Tests;

use PE\Component\Cronos\Expression\ExpressionFactory;
use PE\Component\Cronos\Expression\Field\DayOfMonthFieldFactory;
use PE\Component\Cronos\Expression\Field\DayOfWeekFieldFactory;
use PE\Component\Cronos\Expression\Field\HourFieldFactory;
use PE\Component\Cronos\Expression\Field\MinuteFieldFactory;
use PE\Component\Cronos\Expression\Field\MonthFieldFactory;
use PE\Component\Cronos\Expression\Field\SecondFieldFactory;
use PHPUnit\Framework\TestCase;

class ExpressionTest extends TestCase
{
    protected function createFactory(): ExpressionFactory
    {
        return new ExpressionFactory([
            new SecondFieldFactory(),
            new MinuteFieldFactory(),
            new HourFieldFactory(),
            new DayOfMonthFieldFactory(),
            new MonthFieldFactory(),
            new DayOfWeekFieldFactory(),
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNormalizeInvalidDate()
    {
        $expression = $this->createFactory()->create('* * * * * *');
        $expression->isDue(new \stdClass());
    }

    public function testIsDue()
    {
        $expression = $this->createFactory()->create('* * * * * *');
        static::assertTrue($expression->isDue());
    }

    public function testGetDueRunDate()
    {
        $expression = $this->createFactory()->create('* * * * * *');

        $date1 = $expression->getDueRunDate();
        $date2 = new \DateTime();

        static::assertEquals($date1->format('Y-m-d H:i:s'), $date2->format('Y-m-d H:i:s'));
    }

    public function testGetPrevRunDate()
    {
        $expression = $this->createFactory()->create('* * * * * *');

        $base = new \DateTime('2000-01-01 00:00:00');

        $date1 = $expression->getPrevRunDate(clone $base);

        $base->modify('-1 second');
        $date2 = clone $base;

        static::assertEquals($date1->format('Y-m-d H:i:s'), $date2->format('Y-m-d H:i:s'));
    }

    public function testGetPrevRunDateForIncrement()
    {
        $expression = $this->createFactory()->create('0/5 * * * * *');

        $base = new \DateTime('2000-01-01 00:00:00');

        $date1 = $expression->getPrevRunDate(clone $base);

        $base->modify('-5 second');
        $date2 = clone $base;

        static::assertEquals($date1->format('Y-m-d H:i:s'), $date2->format('Y-m-d H:i:s'));
    }

    public function testGetNextRunDate()
    {
        $expression = $this->createFactory()->create('* * * * * *');

        $base = new \DateTime('2000-01-01 00:00:00');

        $date1 = $expression->getNextRunDate(clone $base);

        $base->modify('+1 second');
        $date2 = clone $base;

        static::assertEquals($date1->format('Y-m-d H:i:s'), $date2->format('Y-m-d H:i:s'));
    }

    public function testGetNextRunDateForIncrement()
    {
        $expression = $this->createFactory()->create('0/5 * * * * *');

        $base = new \DateTime('2000-01-01 00:00:00');

        $date1 = $expression->getNextRunDate(clone $base);

        $base->modify('+5 second');
        $date2 = clone $base;

        static::assertEquals($date1->format('Y-m-d H:i:s'), $date2->format('Y-m-d H:i:s'));
    }

    public function testToString(): void
    {
        $expression = $this->createFactory()->create('0/5 * * * * *');

        self::assertSame('0/5 * * * * *', (string) $expression);
    }
}
