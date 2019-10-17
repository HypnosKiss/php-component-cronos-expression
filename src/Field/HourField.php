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
        if ($this->each) {
            $timezone = $dateTime->getTimezone();

            // Change timezone to UTC temporarily.
            // This will allow us to go back or forwards and hour even if DST will be changed between the hours.
            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $dateTime->modify('-1 hour');
            $dateTime->setTimezone($timezone);
            $dateTime->setTime($dateTime->format('H'), 59);
        } else {
            $current  = $dateTime->format('H');
            $position = count($this->values) - 1;

            for ($i = count($this->values) - 1; $i > 0; $i--) {
                if ($current <= $this->values[$i] && $current > $this->values[$i - 1]) {
                    $position = $i - 1;
                    break;
                }
            }

            if ($current <= $this->values[$position]) {
                $dateTime->modify('- 1 day');
                $dateTime->setTime(23, 59);
            } else {
                $dateTime->setTime($this->values[$position], 59);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function increment(\DateTime $dateTime)
    {
        if ($this->each) {
            $timezone = $dateTime->getTimezone();

            // Change timezone to UTC temporarily.
            // This will allow us to go back or forwards and hour even if DST will be changed between the hours.
            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $dateTime->modify('+1 hour');
            $dateTime->setTimezone($timezone);
            $dateTime->setTime($dateTime->format('H'), 0);
        } else {
            $current  = $dateTime->format('H');
            $position = 0;

            for ($i = 0; $i < count($this->values) - 1; $i++) {
                if ($current >= $this->values[$i] && $current < $this->values[$i + 1]) {
                    $position = $i + 1;
                    break;
                }
            }

            if ($current >= $this->values[$position]) {
                $dateTime->modify('+ 1 day');
                $dateTime->setTime(0, 0);
            } else {
                $dateTime->setTime($this->values[$position], 0);
            }
        }
    }
}
