<?php

namespace PE\Component\Cronos\Expression\Field;

class MinuteField extends AbstractField
{
    /**
     * @inheritDoc
     */
    protected function doMatch(\DateTime $dateTime): bool
    {
        return in_array((int) $dateTime->format('i'), $this->values);
    }

    /**
     * @inheritDoc
     */
    public function decrement(\DateTime $dateTime)
    {
        if ($this->each) {
            $dateTime->modify('-1 minute');
        } else {
            $current  = $dateTime->format('i');
            $position = count($this->values) - 1;

            for ($i = count($this->values) - 1; $i > 0; $i--) {
                if ($current <= $this->values[$i] && $current > $this->values[$i - 1]) {
                    $position = $i - 1;
                    break;
                }
            }

            if ($current <= $this->values[$position]) {
                $dateTime->modify('- 1 hour');
                $dateTime->setTime($dateTime->format('H'), 59);
            } else {
                $dateTime->setTime($dateTime->format('H'), $this->values[$position]);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function increment(\DateTime $dateTime)
    {
        if ($this->each) {
            $dateTime->modify('+1 minute');
        } else {
            $current  = $dateTime->format('i');
            $position = 0;

            for ($i = 0; $i < count($this->values) - 1; $i++) {
                if ($current >= $this->values[$i] && $current < $this->values[$i + 1]) {
                    $position = $i + 1;
                    break;
                }
            }

            if ($current >= $this->values[$position]) {
                $dateTime->modify('+ 1 hour');
                $dateTime->setTime($dateTime->format('H'), 0);
            } else {
                $dateTime->setTime($dateTime->format('H'), $this->values[$position]);
            }
        }
    }
}
