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
class SequenceOfSchemaNodesNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var SchemaNode[] */
    private $schemaNodes = [];

    /**
     * @param ObjectSchemaNode $parent
     * @param array $schemaNodes
     */
    public function __construct(ObjectSchemaNode $parent, array $schemaNodes = [])
    {
        $this->parent = $parent;
        $this->setSchemaNodes($schemaNodes);
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
    public function getSchemaNodes(): array
    {
        return $this->schemaNodes;
    }

    /**
     * @param SchemaNode[] $schemaNodes
     * @return void
     */
    public function setSchemaNodes(array $schemaNodes): void
    {
        $this->schemaNodes = [];
        \array_walk($schemaNodes, [$this, 'addSchemaNode']);
    }

    /**
     * @param SchemaNode $schemaNode
     * @return void
     */
    public function addSchemaNode(SchemaNode $schemaNode): void
    {
        $this->schemaNodes[] = $schemaNode;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitSequenceOfSchemaNodes($this);
    }
}