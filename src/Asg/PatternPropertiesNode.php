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
class PatternPropertiesNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var PatternPropertyNode[] */
    private $patternProperties = [];

    /**
     * @param ObjectSchemaNode $parent
     * @param PatternPropertyNode[] $properties
     */
    public function __construct(ObjectSchemaNode $parent, array $properties = [])
    {
        $this->parent = $parent;
        $this->setPatternProperties($properties);
    }

    /**
     * @return ObjectSchemaNode
     */
    public function getParent(): ObjectSchemaNode
    {
        return $this->parent;
    }

    /**
     * @return PatternPropertyNode[]
     */
    public function getPatternProperties(): array
    {
        return $this->patternProperties;
    }

    /**
     * @param PatternPropertyNode[] $patternProperties
     * @return void
     */
    public function setPatternProperties(array $patternProperties): void
    {
        $this->patternProperties = [];
        \array_walk($patternProperties, [$this, 'addPatternPropertyNode']);
    }

    /**
     * @param PatternPropertyNode $propertyNode
     * @return void
     */
    public function addPatternPropertyNode(PatternPropertyNode $propertyNode): void
    {
        $this->patternProperties[] = $propertyNode;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitPatternPropertiesNode($this);
    }
}