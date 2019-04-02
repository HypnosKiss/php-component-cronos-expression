<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\AbstractFieldFactory;
use PHPUnit\Framework\TestCase;

class AbstractFieldFactoryTest extends TestCase
{
    /**
     * @param int $min
     * @param int $max
     *
     * @return AbstractFieldFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createFactory(int $min, int $max)
    {
        $factory = $this->getMockForAbstractClass(AbstractFieldFactory::class);
        $factory->method('getMIN')->willReturn($min);
        $factory->method('getMAX')->willReturn($max);

        return $factory;
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testResolveIncrementValuesInvalidStep()
    {
        $this->createFactory(0, 10)->resolveIncrementValues(0, 0);
    }

    public function testResolveIncrementValues()
    {
        static::assertEquals([0, 2, 4, 6, 8, 10], $this->createFactory(0, 10)->resolveIncrementValues(0, 2));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testResolveRangeValuesInvalidRange()
    {
        $this->createFactory(0, 10)->resolveRangeValues(10, 0);
    }

    public function testResolveRangeValues()
    {
        static::assertEquals([3, 4, 5, 6, 7], $this->createFactory(0, 10)->resolveRangeValues(3, 7));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveSingularValueInvalidMin()
    {
        $this->createFactory(0, 10)->resolveSingularValue(11);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testResolveSingularValueInvalidMax()
    {
        $this->createFactory(0, 10)->resolveSingularValue(-1);
    }

    public function testResolveSingularValue()
    {
        static::assertEquals(3, $this->createFactory(0, 10)->resolveSingularValue(3));
    }
}
