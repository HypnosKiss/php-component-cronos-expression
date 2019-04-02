<?php

namespace PE\Component\Cronos\Expression\Field;

class YearFieldFactory extends AbstractFieldFactory
{
    /**
     * @inheritDoc
     */
    protected function getMIN(): int
    {
        return 1970;
    }

    /**
     * @inheritDoc
     */
    protected function getMAX(): int
    {
        return 2038;
    }

    /**
     * @inheritDoc
     */
    public function createField(array $values, bool $each, string $raw): FieldInterface
    {
        return new YearField($values, $each, $raw);
    }
}
