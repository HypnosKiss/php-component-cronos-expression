<?php

namespace PE\Component\Cronos\Expression;

use PE\Component\Cronos\Expression\Field\FieldInterface;
use PE\Component\Cronos\Expression\Field\SecondField;

class Expression
{
    /**
     * @var FieldInterface[]
     */
    private $fields;

    /**
     * @var int
     */
    private $iterations;

    /**
     * @param FieldInterface[] $fields
     * @param int              $iterations
     */
    public function __construct(array $fields, int $iterations = 1000)
    {
        $this->fields     = $fields;
        $this->iterations = $iterations;
    }

    /**
     * Get original expression string
     *
     * @return string
     */
    public function __toString()
    {
        return implode(' ', array_map('strval', $this->fields));
    }

    /**
     * @param string|\DateTime $currentDate
     *
     * @return bool
     */
    public function isDue($currentDate = 'now'): bool
    {
        $currentDate = $this->normalizeDateTime($currentDate);
        return $this->getDueRunDate($currentDate)->getTimestamp() == $currentDate->getTimestamp();
    }

    /**
     * @param string|\DateTime $currentDate
     *
     * @return \DateTime
     */
    public function getPrevRunDate($currentDate = 'now'): \DateTime
    {
        $currentDate = $this->normalizeDateTime($currentDate);
        return $this->resolveRunDate($currentDate, false);
    }

    /**
     * @param string|\DateTime $currentDate
     *
     * @return \DateTime
     */
    public function getDueRunDate($currentDate = 'now'): \DateTime
    {
        $currentDate = $this->normalizeDateTime($currentDate);
        return $this->resolveRunDate($currentDate, false, true);
    }

    /**
     * @param string|\DateTime $currentDate
     *
     * @return \DateTime
     */
    public function getNextRunDate($currentDate = 'now'): \DateTime
    {
        $currentDate = $this->normalizeDateTime($currentDate);
        return $this->resolveRunDate($currentDate, true);
    }

    /**
     * @param \DateTime $currentDate
     * @param bool      $forward
     * @param bool      $allowCurrent
     *
     * @return \DateTime
     */
    private function resolveRunDate(\DateTime $currentDate, bool $forward, bool $allowCurrent = false): \DateTime
    {
        $runDate = clone $currentDate;

        for ($i = 0; $i < $this->iterations; $i++) {
            foreach ($this->fields as $field) {
                if (!$field->match($runDate)) {
                    if ($forward) {
                        $field->increment($runDate);
                    } else {
                        $field->decrement($runDate);
                    }
                    continue 2;
                }
            }

            // Skip this match if needed
            if ((!$allowCurrent && $runDate == $currentDate)) {
                if ($forward) {
                    $this->fields[0]->increment($runDate);
                } else {
                    $this->fields[0]->decrement($runDate);
                }
                continue;
            }

            return $runDate;
        }

        // @codeCoverageIgnoreStart
        throw new \RuntimeException('Impossible CRON expression: ' . $this);
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param string|\DateTime $date
     *
     * @return \DateTime
     */
    protected function normalizeDateTime($date): \DateTime
    {
        $useSeconds = false;

        foreach ($this->fields as $field) {
            if ($field instanceof SecondField) {
                $useSeconds = true;
            }
        }

        if (is_string($date)) {
            $result = new \DateTime($date);
            $result->setTime($result->format('H'), $result->format('i'), $useSeconds ? $result->format('s') : 0);
        } else if ($date instanceof \DateTime) {
            $result = clone $date;
            $result->setTime($result->format('H'), $result->format('i'), $useSeconds ? $result->format('s') : 0);
            // Ensure time in 'current' timezone is used
            $result->setTimezone(new \DateTimeZone(date_default_timezone_get()));
        } else {
            throw new \InvalidArgumentException('The $date argument is expected to be a string or instance of \DateTime');
        }

        return $result;
    }
}
