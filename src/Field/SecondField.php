<?php

namespace PE\Component\Cronos\Expression\Field;

class SecondField extends AbstractField
{
    /**
     * @inheritDoc
     */
    protected function doMatch(\DateTime $dateTime): bool
    {
        return in_array((int) $dateTime->format('s'), $this->values);
    }

    /**
     * @inheritDoc
     */
    public function decrement(\DateTime $dateTime)
    {
        $dateTime->modify('-1 second');
    }

    /**
     * @inheritDoc
     */
    public function increment(\DateTime $dateTime)
    {
        $dateTime->modify('+1 second');
    }
}