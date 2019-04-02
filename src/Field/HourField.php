<?php

namespace PE\Component\Cronos\Expression\Field;

class HourField extends AbstractField
{
    /**
     * @inheritDoc
     */
    protected function doMatch(\DateTime $dateTime): bool
    {
        return in_array((int) $dateTime->format('H'), $this->values);
    }

    /**
     * @inheritDoc
     */
    public function decrement(\DateTime $dateTime)
    {
        $timezone = $dateTime->getTimezone();

        // Change timezone to UTC temporarily.
        // This will allow us to go back or forwards and hour even if DST will be changed between the hours.
        $dateTime->setTimezone(new \DateTimeZone('UTC'));
        $dateTime->modify('-1 hour');
        $dateTime->setTimezone($timezone);
        $dateTime->setTime($dateTime->format('H'), 59);
    }

    /**
     * @inheritDoc
     */
    public function increment(\DateTime $dateTime)
    {
        $timezone = $dateTime->getTimezone();

        // Change timezone to UTC temporarily.
        // This will allow us to go back or forwards and hour even if DST will be changed between the hours.
        $dateTime->setTimezone(new \DateTimeZone('UTC'));
        $dateTime->modify('+1 hour');
        $dateTime->setTimezone($timezone);
        $dateTime->setTime($dateTime->format('H'), 0);
    }
}