<?php

namespace PE\Component\Cronos\Expression\Field;

class DayOfWeekField extends AbstractField
{
    /**
     * @inheritDoc
     */
    protected function doMatch(\DateTime $dateTime): bool
    {
        return in_array(((int) $dateTime->format('N') - 1), $this->values);
    }

    /**
     * @inheritDoc
     */
    public function decrement(\DateTime $dateTime)
    {
        $dateTime->modify('-1 day');
        $dateTime->setTime(23, 59, 0);
    }

    /**
     * @inheritDoc
     */
    public function increment(\DateTime $dateTime)
    {
        $dateTime->modify('+1 day');
        $dateTime->setTime(0, 0, 0);
    }
}