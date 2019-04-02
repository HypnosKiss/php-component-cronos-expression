<?php

namespace PE\Component\Cronos\Expression\Field;

interface FieldFactoryInterface
{
    /**
     * @param int $from
     * @param int $till
     *
     * @return int[]
     *
     * @throws \InvalidArgumentException
     */
    public function resolveRangeValues(int $from, int $till): array;

    /**
     * @param int $from
     * @param int $step
     *
     * @return int[]
     *
     * @throws \InvalidArgumentException
     */
    public function resolveIncrementValues(int $from, int $step): array;

    /**
     * @param int $value
     *
     * @return int
     *
     * @throws \InvalidArgumentException
     */
    public function resolveSingularValue(int $value): int;

    /**
     * @param array  $values
     * @param bool   $each
     * @param string $raw
     *
     * @return FieldInterface
     */
    public function createField(array $values, bool $each, string $raw): FieldInterface;
}
