<?php

namespace PE\Component\Cronos\Expression\Field;

class YearField extends AbstractField
{
    /**
     * @inheritDoc
     */
    protected function doMatch(\DateTime $dateTime): bool
    {
        return in_array((int) $dateTime->format('Y'), $this->values);
    }

    /**
     * @inheritDoc
     */
    public function decrement(\DateTime $dateTime)
    {
        $dateTime->modify('-1 year');
        $dateTime->setDate($dateTime->format('Y'), 12, 31);
        $dateTime->setTime(23, 59, 0);
    }

    /**
     * @inheritDoc
     */
    public function increment(\DateTime $dateTime)
    {
        $dateTime->modify('+1 year');
        $dateTime->setDate($dateTime->format('Y'), 1, 1);
        $dateTime->setTime(0, 0, 0);
    }
}