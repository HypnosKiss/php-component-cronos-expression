<?php

namespace PE\Component\Cronos\Expression\Field;

abstract class AbstractFieldFactory implements FieldFactoryInterface
{
    /**
     * @return int
     */
    abstract protected function getMIN(): int;

    /**
     * @return int
     */
    abstract protected function getMAX(): int;

    /**
     * @param int $min
     * @param int $max
     *
     * @throws \OutOfRangeException
     */
    private function validateBounds($min, $max)
    {
        if ($this->getMIN() > $min || $this->getMAX() < $max) {
            throw new \OutOfRangeException(sprintf('Invalid range %s-%s', $min, $max));
        }
    }

    /**
     * @inheritDoc
     */
    public function resolveRangeValues(int $from, int $till): array
    {
        if ($from >= $till) {
            throw new \InvalidArgumentException(sprintf('Invalid range %s-%s', $from, $till));
        }

        $this->validateBounds($from, $till);

        return range($from, $till);
    }

    /**
     * @inheritDoc
     */
    public function resolveIncrementValues(int $from, int $step): array
    {
        if (0 == $step) {
            throw new \InvalidArgumentException(sprintf('Invalid increment %s/%s', $from, $step));
        }

        $this->validateBounds($from, $from + $step);

        return range($from, $this->getMAX(), $step);
    }

    /**
     * @inheritDoc
     */
    public function resolveSingularValue(int $value): int
    {
        $this->validateBounds($value, $value);
        return $value;
    }
}