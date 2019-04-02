<?php

namespace PE\Component\Cronos\Expression\Field;

class MinuteFieldFactory extends AbstractFieldFactory
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
        return 59;
    }

    /**
     * @inheritDoc
     */
    public function createField(array $values, bool $each, string $raw): FieldInterface
    {
        return new MinuteField($values, $each, $raw);
    }
}
