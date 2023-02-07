<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
declare(strict_types=1);

namespace Jojo1981\JsonSchemaAsg\Asg;

use Jojo1981\JsonSchemaAsg\Visitor\VisitableInterface;
use Jojo1981\JsonSchemaAsg\Visitor\VisitorInterface;

/**
 * @package Jojo1981\JsonSchemaAsg\Ast
 */
class PatternPropertyNode implements NodeInterface, VisitableInterface
{
    /** @var string */
    private string $pattern;

    /** @var SchemaNode */
    private SchemaNode $schema;

    /**
     * @param string $pattern
     * @param SchemaNode $schema
     */
    public function __construct(string $pattern, SchemaNode $schema)
    {
        $this->pattern = $pattern;
        $this->schema = $schema;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return SchemaNode
     */
    public function getSchema(): SchemaNode
    {
        return $this->schema;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitPatternPropertyNode($this);
    }
}
