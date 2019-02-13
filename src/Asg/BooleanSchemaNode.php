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

use Jojo1981\JsonSchemaAsg\Visitor\VisitorInterface;

/**
 * @package Jojo1981\JsonSchemaAsg\Ast
 */
class BooleanSchemaNode extends SchemaNode
{
    /** @var bool */
    private $value;

    /**
     * @param bool $value
     * @param NodeInterface|null $parent
     */
    public function __construct(bool $value, ?NodeInterface $parent = null)
    {
        parent::__construct($parent);
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * @param bool $value
     * @return void
     */
    public function setValue(bool $value): void
    {
        $this->value = $value;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitBooleanSchemaNode($this);
    }
}