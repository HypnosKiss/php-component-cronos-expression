<?php

namespace PE\Component\Cronos\Expression\Field;

interface FieldInterface
{
    /**
     * @param array  $values
     * @param bool   $each
     * @param string $raw
     */
    public function __construct(array $values, bool $each, string $raw);

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    public function match(\DateTime $dateTime): bool;

    /**
     * @param \DateTime $dateTime
     */
    public function decrement(\DateTime $dateTime);

    /**
     * @param \DateTime $dateTime
     */
    public function increment(\DateTime $dateTime);
}
