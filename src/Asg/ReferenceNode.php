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

/***
 * @package Jojo1981\JsonSchemaAsg\Ast
 */
class ReferenceNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var string */
    private $originalReference;

    /** @var string */
    private $resolvedReference;

    /** @var SchemaNode */
    private $pointToSchema;

    /** @var bool */
    private $circular = false;

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
     * @return string
     */
    public function getOriginalReference(): string
    {
        return $this->originalReference;
    }

    /**
     * @param string $originalReference
     * @return void
     */
    public function setOriginalReference(string $originalReference): void
    {
        $this->originalReference = $originalReference;
    }

    /**
     * @return string
     */
    public function getResolvedReference(): string
    {
        return $this->resolvedReference;
    }

    /**
     * @param string $resolvedReference
     * @return void
     */
    public function setResolvedReference(string $resolvedReference): void
    {
        $this->resolvedReference = $resolvedReference;
    }

    /**
     * @return SchemaNode
     */
    public function getPointToSchema(): SchemaNode
    {
        return $this->pointToSchema;
    }

    /**
     * @param SchemaNode $pointToSchema
     * @return void
     */
    public function setPointToSchema(SchemaNode $pointToSchema): void
    {
        $this->pointToSchema = $pointToSchema;
    }

    /**
     * @return bool
     */
    public function isCircular(): bool
    {
        return $this->circular;
    }

    /**
     * @param bool $circular
     * @return void
     */
    public function setCircular(bool $circular): void
    {
        $this->circular = $circular;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitReferenceNode($this);
    }
}