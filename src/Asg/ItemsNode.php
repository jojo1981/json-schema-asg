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
class ItemsNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var SchemaNode[] */
    private $schemas = [];

    /**
     * @param ObjectSchemaNode $parent
     */
    public function __construct(ObjectSchemaNode $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return ObjectSchemaNode
     */
    public function getParent(): ObjectSchemaNode
    {
        return $this->parent;
    }

    /**
     * @param ObjectSchemaNode $parent
     * @return void
     */
    public function setParent(ObjectSchemaNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return SchemaNode[]
     */
    public function getSchemas(): array
    {
        return $this->schemas;
    }

    /**
     * @param SchemaNode[] $schemas
     * @return void
     */
    public function setSchemas(array $schemas): void
    {
        $this->schemas = [];
        \array_walk($schemas, [$this, 'addSchema']);
    }

    /**
     * @param SchemaNode $schemaNode
     * @return void
     */
    public function addSchema(SchemaNode $schemaNode): void
    {
        $this->schemas[] = $schemaNode;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitItemsNode($this);
    }
}