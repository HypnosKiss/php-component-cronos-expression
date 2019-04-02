<?php

namespace PE\Component\Cronos\Expression\Field;

abstract class AbstractField implements FieldInterface
{
    protected $values;
    protected $each;

    /**
     * @var string
     */
    private $raw;

    /**
     * @inheritDoc
     */
    public function __construct(array $values, bool $each, string $raw)
    {
        $this->values = $values;
        $this->each   = $each;
        $this->raw    = $raw;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->raw;
    }

    /**
     * @inheritDoc
     */
    public function match(\DateTime $dateTime): bool
    {
        return $this->each ?: $this->doMatch($dateTime);
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    abstract protected function doMatch(\DateTime $dateTime): bool;
}
