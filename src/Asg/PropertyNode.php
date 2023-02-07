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
class PropertyNode implements NodeInterface, VisitableInterface
{
    /** @var string */
    private string $name;

    /** @var SchemaNode */
    private SchemaNode $schema;

    /**
     * @param string $name
     * @param SchemaNode $schema
     */
    public function __construct(string $name, SchemaNode $schema)
    {
        $this->name = $name;
        $this->schema = $schema;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
        return $visitor->visitPropertyNode($this);
    }
}
