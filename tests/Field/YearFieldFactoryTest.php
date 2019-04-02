<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\YearField;
use PE\Component\Cronos\Expression\Field\YearFieldFactory;
use PHPUnit\Framework\TestCase;

class YearFieldFactoryTest extends TestCase
{
    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMin()
    {
        (new YearFieldFactory())->resolveRangeValues(1000, 2000);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveRangeValuesInvalidMax()
    {
        (new YearFieldFactory())->resolveRangeValues(2000, 3000);
    }

    public function testResolveRangeValues()
    {
        static::assertEquals(range(1970, 2038), (new YearFieldFactory())->resolveRangeValues(1970, 2038));
    }

    public function testCreateField()
    {
        static::assertInstanceOf(
            YearField::class,
            (new YearFieldFactory())->createField([1999, 2000], false, '1999,2000')
        );
    }
}
