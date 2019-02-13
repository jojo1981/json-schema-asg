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
class PropertyNode implements NodeInterface, VisitableInterface
{
    /** @var PropertiesNode */
    private $parent;

    /** @var string */
    private $name;

    /** @var SchemaNode */
    private $schema;

    /**
     * @param PropertiesNode $parent
     * @param string $name
     */
    public function __construct(PropertiesNode $parent, string $name)
    {
        $this->parent = $parent;
        $this->name = $name;
    }

    /**
     * @return PropertiesNode
     */
    public function getParent(): PropertiesNode
    {
        return $this->parent;
    }

    /**
     * @param PropertiesNode $parent
     * @return void
     */
    public function setParent(PropertiesNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return SchemaNode
     */
    public function getSchema(): SchemaNode
    {
        return $this->schema;
    }

    /**
     * @param SchemaNode $schema
     * @return void
     */
    public function setSchema(SchemaNode $schema): void
    {
        $this->schema = $schema;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitPropertyNode($this);
    }
}