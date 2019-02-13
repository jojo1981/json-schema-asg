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
class DependenciesNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private $parent;

    /** @var null|SchemaNode */
    private $schema;

    /** @var null|string[] */
    private $sequenceOfString;

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
     * @return SchemaNode|null
     */
    public function getSchema(): ?SchemaNode
    {
        return $this->schema;
    }

    /**
     * @param SchemaNode|null $schema
     * @return void
     */
    public function setSchema(?SchemaNode $schema): void
    {
        $this->schema = $schema;
    }

    /**
     * @return null|string[]
     */
    public function getSequenceOfString(): ?array
    {
        return $this->sequenceOfString;
    }

    /**
     * @param null|string[] $sequenceOfString
     * @return void
     */
    public function setSequenceOfString(?array $sequenceOfString): void
    {
        $this->sequenceOfString = $sequenceOfString;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitDependenciesNode($this);
    }
}