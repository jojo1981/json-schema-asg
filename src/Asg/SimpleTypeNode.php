<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Asg;

use Jojo1981\JsonSchemaAsg\Visitor\VisitableInterface;
use Jojo1981\JsonSchemaAsg\Visitor\VisitorInterface;

/**
 * @package Jojo1981\JsonSchemaAsg\Ast
 */
class SimpleTypeNode implements NodeInterface, VisitableInterface
{
    public const TYPE_ARRAY = 'array';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_NULL = 'null';
    public const TYPE_NUMBER = 'number';
    public const TYPE_OBJECT = 'object';
    public const TYPE_STRING = 'string';

    /** @var SimpleTypesSequenceNode */
    private $parent;

    /** @var string */
    private $value;

    /**
     * @param SimpleTypesSequenceNode $parent
     * @param string $value
     * @throws \InvalidArgumentException
     */
    public function __construct(SimpleTypesSequenceNode $parent, string $value)
    {
        $this->assertType($value);
        $this->parent = $parent;
        $this->value = $value;
    }

    /**
     * @return SimpleTypesSequenceNode
     */
    public function getParent(): SimpleTypesSequenceNode
    {
        return $this->parent;
    }

    /**
     * @param SimpleTypesSequenceNode $parent
     * @return void
     */
    public function setParent(SimpleTypesSequenceNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isArray(): bool
    {
        return self::TYPE_ARRAY === $this->value;
    }

    /**
     * @return bool
     */
    public function isBoolean(): bool
    {
        return self::TYPE_BOOLEAN === $this->value;
    }

    /**
     * @return bool
     */
    public function isInteger(): bool
    {
        return self::TYPE_INTEGER === $this->value;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return self::TYPE_NULL === $this->value;
    }

    /**
     * @return bool
     */
    public function isNumber(): bool
    {
        return self::TYPE_NULL === $this->value;
    }

    /**
     * @return bool
     */
    public function isObject(): bool
    {
        return self::TYPE_OBJECT === $this->value;
    }

    /**
     * @return bool
     */
    public function isString(): bool
    {
        return self::TYPE_STRING === $this->value;
    }

    /**
     * @param string $type
     * @return bool
     */
    public static function isValidType(string $type): bool
    {
        return \in_array($type, self::getValidTypes(), true);
    }

    /**
     * @return string[]
     */
    public static function getValidTypes(): array
    {
        return [
            self::TYPE_ARRAY,
            self::TYPE_BOOLEAN,
            self::TYPE_INTEGER,
            self::TYPE_NULL,
            self::TYPE_NUMBER,
            self::TYPE_OBJECT,
            self::TYPE_STRING,
        ];
    }

    /**
     * @param string $type
     * @throws \InvalidArgumentException
     * @return void
     */
    private function assertType(string $type): void
    {
        if (!\in_array($type, self::getValidTypes(), true)) {
            throw new \InvalidArgumentException(\sprintf(
                'Invalid type: %s given. Valid types are: [%s]',
                $type,
                self::getValidTypes()
            ));
        }
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitSimpleTypeNode($this);
    }
}