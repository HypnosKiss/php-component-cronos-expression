<?php

namespace PE\Component\Cronos\Expression\Field;

class DayOfMonthField extends AbstractField
{
    /**
     * @inheritDoc
     */
    protected function doMatch(\DateTime $dateTime): bool
    {
        return in_array((int) $dateTime->format('d'), $this->values);
    }

    /**
     * @inheritDoc
     */
    public function decrement(\DateTime $dateTime)
    {
        $dateTime->modify('previous day');
        $dateTime->setTime(23, 59);
    }

    /**
     * @inheritDoc
     */
    public function increment(\DateTime $dateTime)
    {
        $dateTime->modify('next day');
        $dateTime->setTime(0, 0);
    }
}