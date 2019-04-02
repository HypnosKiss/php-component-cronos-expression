<?php

namespace PE\Component\Cronos\Expression\Field;

class MonthField extends AbstractField
{
    /**
     * @inheritDoc
     */
    protected function doMatch(\DateTime $dateTime): bool
    {
        return in_array((int) $dateTime->format('m'), $this->values);
    }

    /**
     * @inheritDoc
     */
    public function decrement(\DateTime $dateTime)
    {
        $dateTime->modify('last day of previous month');
        $dateTime->setTime(23, 59);
    }

    /**
     * @inheritDoc
     */
    public function increment(\DateTime $dateTime)
    {
        $dateTime->modify('first day of next month');
        $dateTime->setTime(0, 0);
    }
}