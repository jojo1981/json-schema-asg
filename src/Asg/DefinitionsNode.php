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
class DefinitionsNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var DefinitionNode[] */
    private $definitionNodes = [];

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
     * @return DefinitionNode[]
     */
    public function getDefinitionNodes(): array
    {
        return $this->definitionNodes;
    }

    /**
     * @param DefinitionNode[] $definitionNodes
     * @return void
     */
    public function setDefinitionNodes(array $definitionNodes): void
    {
        $this->definitionNodes = [];
        \array_walk($definitionNodes, [$this, 'addDefinitionNode']);
    }

    /**
     * @param DefinitionNode $definitionNode
     * @return void
     */
    public function addDefinitionNode(DefinitionNode $definitionNode): void
    {
        $this->definitionNodes[] = $definitionNode;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitDefinitionsNode($this);
    }
}