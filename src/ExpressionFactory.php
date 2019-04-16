<?php

namespace PE\Component\Cronos\Expression;

use PE\Component\Cronos\Expression\Field\DayOfMonthFieldFactory;
use PE\Component\Cronos\Expression\Field\DayOfWeekFieldFactory;
use PE\Component\Cronos\Expression\Field\FieldFactoryInterface;
use PE\Component\Cronos\Expression\Field\HourFieldFactory;
use PE\Component\Cronos\Expression\Field\MinuteFieldFactory;
use PE\Component\Cronos\Expression\Field\MonthFieldFactory;

class ExpressionFactory
{
    /**
     * @var FieldFactoryInterface[]
     */
    private $fieldFactories = [];

    /**
     * @var int
     */
    private $iterations;

    /**
     * @param FieldFactoryInterface[] $fieldFactories
     * @param int                     $iterations
     */
    public function __construct(array $fieldFactories = [], int $iterations = 1000)
    {
        if (empty($fieldFactories)) {
            $fieldFactories = [
                new MinuteFieldFactory(),
                new HourFieldFactory(),
                new DayOfMonthFieldFactory(),
                new MonthFieldFactory(),
                new DayOfWeekFieldFactory(),
            ];
        }

        foreach ($fieldFactories as $fieldFactory) {
            $this->addFieldFactory($fieldFactory);
        }

        $this->iterations = $iterations;
    }

    /**
     * @param FieldFactoryInterface $fieldFactory
     *
     * @throws \InvalidArgumentException
     */
    public function addFieldFactory(FieldFactoryInterface $fieldFactory): void
    {
        foreach ($this->fieldFactories as $existFactory) {
            if ($fieldFactory instanceof $existFactory) {
                throw new \InvalidArgumentException('Cannot add same factory twice');
            }
        }

        $this->fieldFactories[] = $fieldFactory;
    }

    /**
     * @return FieldFactoryInterface[]
     */
    public function getFieldFactories(): array
    {
        return $this->fieldFactories;
    }

    /**
     * @param string $expression
     *
     * @return Expression
     *
     * @throws \InvalidArgumentException
     */
    public function create(string $expression): Expression
    {
        $parts = preg_split('/\s/', $expression, -1, PREG_SPLIT_NO_EMPTY);
        $parts = array_slice($parts, 0, count($this->fieldFactories));

        $fields = [];
        foreach ($parts as $position => $part) {
            $fieldFactory = $this->fieldFactories[$position];

            $each   = '*' === $part;
            $values = [];

            if (!$each) {
                $elements = explode(',', $part);

                foreach ($elements as $element) {
                    if (preg_match('/^(\d+)-(\d+)$/', $element, $matches)) {
                        array_push(
                            $values,
                            ...$fieldFactory->resolveRangeValues((int) $matches[1], (int) $matches[2])
                        );
                    } else if (preg_match('/^(\d+)\/(\d+)$/', $element, $matches)) {
                        array_push(
                            $values,
                            ...$fieldFactory->resolveIncrementValues((int) $matches[1], (int) $matches[2])
                        );
                    } else if (is_numeric($element)) {
                        $values[] = $fieldFactory->resolveSingularValue((int) $element);
                    } else {
                        throw new \InvalidArgumentException(sprintf(
                            'Invalid expression part "%s" at position %s',
                            $element,
                            $position
                        ));
                    }
                }

                $values = array_unique($values);
                sort($values);
            }

            $fields[] = $fieldFactory->createField($values, $each, $part);
        }

        return new Expression($fields, $this->iterations);
    }

    /**
     * @param string $expression
     * @param array  $errors
     *
     * @return bool
     */
    public function validate(string $expression, array &$errors = []): bool
    {
        $parts = preg_split('/\s/', $expression, -1, PREG_SPLIT_NO_EMPTY);
        $parts = array_slice($parts, 0, count($this->fieldFactories));

        $valid = true;
        foreach ($parts as $position => $part) {
            if ('*' === $part) {
                continue;
            }

            $elements = explode(',', $part);

            foreach ($elements as $element) {
                if (
                    is_numeric($element)
                    || preg_match('/^(\d+)-(\d+)$/', $element)
                    || preg_match('/^(\d+)\/(\d+)$/', $element)
                ) {
                    continue;
                }

                $valid    = false;
                $errors[] = sprintf(
                    'Invalid expression part "%s" at position %s',
                    $element,
                    $position
                );

                break;
            }
        }

        return $valid;
    }
}
