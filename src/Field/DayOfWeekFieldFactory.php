<?php

namespace PE\Component\Cronos\Expression\Field;

class DayOfWeekFieldFactory extends AbstractFieldFactory
{
    /**
     * @inheritDoc
     */
    protected function getMIN(): int
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    protected function getMAX(): int
    {
        return 6;
    }

    /**
     * @inheritDoc
     */
    public function createField(array $values, bool $each, string $raw): FieldInterface
    {
        return new DayOfWeekField($values, $each, $raw);
    }
}
