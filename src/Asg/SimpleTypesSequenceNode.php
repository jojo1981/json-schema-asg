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
class SimpleTypesSequenceNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var SimpleTypeNode[] */
    private $simpleTypeNodes = [];

    /**
     * @param ObjectSchemaNode $parent
     * @param array $simpleTypeNodes
     */
    public function __construct(ObjectSchemaNode $parent, array $simpleTypeNodes = [])
    {
        $this->parent = $parent;
        $this->setSimpleTypeNodes($simpleTypeNodes);
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
     * @return SimpleTypeNode[]
     */
    public function getSimpleTypeNodes(): array
    {
        return $this->simpleTypeNodes;
    }

    /**
     * @param SimpleTypeNode[] $simpleTypeNodes
     * @return void
     */
    public function setSimpleTypeNodes(array $simpleTypeNodes): void
    {
        $this->simpleTypeNodes = [];
        \array_walk($simpleTypeNodes, [$this, 'addSimpleTypeNode']);
    }

    /**
     * @param SimpleTypeNode $simpleTypeNode
     * @return void
     */
    public function addSimpleTypeNode(SimpleTypeNode $simpleTypeNode): void
    {
        $this->simpleTypeNodes[] = $simpleTypeNode;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitSimpleTypesSequenceNode($this);
    }
}