<?php

namespace PE\Component\Cronos\Expression\Field;

class HourFieldFactory extends AbstractFieldFactory
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
        return 23;
    }

    /**
     * @inheritDoc
     */
    public function createField(array $values, bool $each, string $raw): FieldInterface
    {
        return new HourField($values, $each, $raw);
    }
}
