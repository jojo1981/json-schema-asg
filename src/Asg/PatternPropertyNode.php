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
class PatternPropertyNode implements NodeInterface, VisitableInterface
{
    /** @var PatternPropertiesNode */
    private $parent;

    /** @var string */
    private $pattern;

    /** @var SchemaNode */
    private $schema;

    /**
     * @param PatternPropertiesNode $parent
     * @param string $pattern
     */
    public function __construct(PatternPropertiesNode $parent, string $pattern)
    {
        $this->parent = $parent;
        $this->pattern = $pattern;
    }

    /**
     * @return PatternPropertiesNode
     */
    public function getParent(): PatternPropertiesNode
    {
        return $this->parent;
    }

    /**
     * @param PatternPropertiesNode $parent
     * @return void
     */
    public function setParent(PatternPropertiesNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     * @return void
     */
    public function setPattern(string $pattern): void
    {
        $this->pattern = $pattern;
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
        return $visitor->visitPatternPropertyNode($this);
    }
}