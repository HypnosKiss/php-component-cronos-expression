<?php

namespace PE\Component\Cronos\Expression\Field;

class MonthFieldFactory extends AbstractFieldFactory
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
        return 12;
    }

    /**
     * @inheritDoc
     */
    public function createField(array $values, bool $each, string $raw): FieldInterface
    {
        return new MonthField($values, $each, $raw);
    }
}
