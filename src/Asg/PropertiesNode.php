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
class PropertiesNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var PropertyNode[] */
    private $properties = [];

    /**
     * @param ObjectSchemaNode $parent
     * @param PropertyNode[] $properties
     */
    public function __construct(ObjectSchemaNode $parent, array $properties = [])
    {
        $this->parent = $parent;
        $this->setProperties($properties);
    }

    /**
     * @return ObjectSchemaNode
     */
    public function getParent(): ObjectSchemaNode
    {
        return $this->parent;
    }

    /**
     * @return PropertyNode[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param PropertyNode[] $properties
     * @return void
     */
    public function setProperties(array $properties): void
    {
        $this->properties = [];
        \array_walk($properties, [$this, 'addPropertyNode']);
    }

    /**
     * @param PropertyNode $propertyNode
     * @return void
     */
    public function addPropertyNode(PropertyNode $propertyNode): void
    {
        $this->properties[] = $propertyNode;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitPropertiesNode($this);
    }
}