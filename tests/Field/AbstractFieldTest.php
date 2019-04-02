<?php

namespace PE\Component\Cronos\Expression\Tests\Field;

use PE\Component\Cronos\Expression\Field\AbstractField;
use PHPUnit\Framework\TestCase;

class AbstractFieldTest extends TestCase
{
    /**
     * @param bool $each
     *
     * @return AbstractField|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createField($each)
    {
        return $this->getMockForAbstractClass(AbstractField::class, [[], $each, '*']);
    }

    public function testMatchBypassIfEach()
    {
        $field = $this->createField(true);
        $field->expects(self::never())->method('doMatch');
        $field->match(new \DateTime());
    }

    public function testMatchCallDoMatchIfNotEach()
    {
        $field = $this->createField(false);
        $field->expects(self::atLeastOnce())->method('doMatch');
        $field->match(new \DateTime());
    }
}
