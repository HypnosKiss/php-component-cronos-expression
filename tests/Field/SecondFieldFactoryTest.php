<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\SecondField;
use PE\Component\Cronos\Expression\Field\SecondFieldFactory;
use PHPUnit\Framework\TestCase;

class SecondFieldFactoryTest extends TestCase
{
    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMin()
    {
        (new SecondFieldFactory())->resolveRangeValues(-1, 1);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMax()
    {
        (new SecondFieldFactory())->resolveRangeValues(1, 100);
    }

    public function testResolveRangeValues()
    {
        static::assertEquals(range(0, 59), (new SecondFieldFactory())->resolveRangeValues(0, 59));
    }

    public function testCreateField()
    {
        static::assertInstanceOf(
            SecondField::class,
            (new SecondFieldFactory())->createField([1, 2], false, '1,2')
        );
    }
}
