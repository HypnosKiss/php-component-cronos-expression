<?php

namespace PE\Component\Cronos\Expression\Tests;

use PE\Component\Cronos\Expression\Expression;
use PE\Component\Cronos\Expression\ExpressionFactory;
use PE\Component\Cronos\Expression\Field\FieldFactoryInterface;
use PE\Component\Cronos\Expression\Field\MinuteFieldFactory;
use PHPUnit\Framework\TestCase;

class ExpressionFactoryTest extends TestCase
{

    public function testConstruct()
    {
        $fieldFactory1 = $this->createMock(FieldFactoryInterface::class);

        $factory = new ExpressionFactory([$fieldFactory1]);

        static::assertSame([$fieldFactory1], $factory->getFieldFactories());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddFieldFactoryExceptionIfAddSameTwice()
    {
        /* @var $fieldFactory1 FieldFactoryInterface */
        $fieldFactory1 = $this->createMock(FieldFactoryInterface::class);

        $factory = new ExpressionFactory([]);
        $factory->addFieldFactory($fieldFactory1);
        $factory->addFieldFactory($fieldFactory1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateExpressionForInvalidField()
    {
        $expressionFactory = new ExpressionFactory([$this->createMock(FieldFactoryInterface::class)]);
        $expressionFactory->create('*/1');
    }

    public function testCreateExpressionForWildcardField()
    {
        $fieldFactoryReal = new MinuteFieldFactory();
        $fieldFactoryMock = $this->createMock(FieldFactoryInterface::class);

        $fieldFactoryMock->expects(static::never())->method('resolveRangeValues');
        $fieldFactoryMock->expects(static::never())->method('resolveIncrementValues');
        $fieldFactoryMock->expects(static::never())->method('resolveSingularValue');

        $fieldFactoryMock
            ->expects(static::once())
            ->method('createField')
            ->willReturnCallback(function (...$arguments) use ($fieldFactoryReal) {
                return $fieldFactoryReal->createField(...$arguments);
            });

        $expressionFactory = new ExpressionFactory([$fieldFactoryMock]);
        $expressionFactory->create('*');
    }

    public function testCreateExpressionForRangeField()
    {
        $fieldFactoryReal = new MinuteFieldFactory();
        $fieldFactoryMock = $this->createMock(FieldFactoryInterface::class);

        $fieldFactoryMock->expects(static::never())->method('resolveIncrementValues');
        $fieldFactoryMock->expects(static::never())->method('resolveSingularValue');

        $fieldFactoryMock
            ->expects(static::once())
            ->method('resolveRangeValues')
            ->willReturnCallback(function (...$arguments) use ($fieldFactoryReal) {
                return $fieldFactoryReal->resolveRangeValues(...$arguments);
            });

        $fieldFactoryMock
            ->expects(static::once())
            ->method('createField')
            ->willReturnCallback(function (...$arguments) use ($fieldFactoryReal) {
                return $fieldFactoryReal->createField(...$arguments);
            });

        $expressionFactory = new ExpressionFactory([$fieldFactoryMock]);
        $expressionFactory->create('1-5');
    }

    public function testCreateExpressionForIncrementField()
    {
        $fieldFactoryReal = new MinuteFieldFactory();
        $fieldFactoryMock = $this->createMock(FieldFactoryInterface::class);

        $fieldFactoryMock->expects(static::never())->method('resolveRangeValues');
        $fieldFactoryMock->expects(static::never())->method('resolveSingularValue');

        $fieldFactoryMock
            ->expects(static::once())
            ->method('resolveIncrementValues')
            ->willReturnCallback(function (...$arguments) use ($fieldFactoryReal) {
                return $fieldFactoryReal->resolveIncrementValues(...$arguments);
            });

        $fieldFactoryMock
            ->expects(static::once())
            ->method('createField')
            ->willReturnCallback(function (...$arguments) use ($fieldFactoryReal) {
                return $fieldFactoryReal->createField(...$arguments);
            });

        $expressionFactory = new ExpressionFactory([$fieldFactoryMock]);
        $expressionFactory->create('0/5');
    }

    public function testCreateExpressionForSingularField()
    {
        $fieldFactoryReal = new MinuteFieldFactory();
        $fieldFactoryMock = $this->createMock(FieldFactoryInterface::class);

        $fieldFactoryMock->expects(static::never())->method('resolveRangeValues');
        $fieldFactoryMock->expects(static::never())->method('resolveIncrementValues');

        $fieldFactoryMock
            ->expects(static::once())
            ->method('resolveSingularValue')
            ->willReturnCallback(function (...$arguments) use ($fieldFactoryReal) {
                return $fieldFactoryReal->resolveSingularValue(...$arguments);
            });

        $fieldFactoryMock
            ->expects(static::once())
            ->method('createField')
            ->willReturnCallback(function (...$arguments) use ($fieldFactoryReal) {
                return $fieldFactoryReal->createField(...$arguments);
            });

        $expressionFactory = new ExpressionFactory([$fieldFactoryMock]);
        $expressionFactory->create('5');
    }

    /*public function testCreate()
    {
        static::assertInstanceOf(Expression::class, (new ExpressionFactory([new MinuteFieldFactory()]))->create('*'));
    }*/
}
