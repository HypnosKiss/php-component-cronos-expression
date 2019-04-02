<?php

namespace PE\Component\Cronos\Expression\Field;

class DayOfMonthFieldFactory extends AbstractFieldFactory
{
    /**
     * @inheritDoc
     */
    protected function getMIN(): int
    {
        return 1;
    }

    /**
     * @inheritDoc
     */
    protected function getMAX(): int
    {
        return 31;
    }

    /**
     * @inheritDoc
     */
    public function createField(array $values, bool $each, string $raw): FieldInterface
    {
        return new DayOfMonthField($values, $each, $raw);
    }
}
