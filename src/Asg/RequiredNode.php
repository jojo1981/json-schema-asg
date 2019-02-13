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
class RequiredNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var string[] */
    private $propertyNames = [];

    /**
     * @param ObjectSchemaNode $parent
     * @param string[] $propertyNames
     */
    public function __construct(ObjectSchemaNode $parent, array $propertyNames)
    {
        $this->parent = $parent;
        $this->setPropertyNames($propertyNames);
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

    /***
     * @return string[]
     */
    public function getPropertyNames(): array
    {
        return $this->propertyNames;
    }

    /**
     * @param string[] $propertyNames
     * @return void
     */
    public function setPropertyNames(array $propertyNames): void
    {
        $this->propertyNames = [];
        \array_walk($propertyNames, [$this, 'addPropertyName']);
    }

    /**
     * @param string $propertyName
     * @return void
     */
    public function addPropertyName(string $propertyName): void
    {
        $this->propertyNames[] = $propertyName;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitRequiredNode($this);
    }
}