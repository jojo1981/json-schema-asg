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
 * @package Jojo1981\JsonSchemaAsg\Asg
 */
class DependencyNode implements NodeInterface, VisitableInterface
{
    /** @var string */
    private string $name;

    /** @var null|SchemaNode */
    private ?SchemaNode $schema;

    /** @var null|string[] */
    private ?array $sequenceOfString;

    /**
     * @param string $name
     * @param array|null $sequenceOfString
     * @param SchemaNode|null $schema
     */
    public function __construct(string $name, ?array $sequenceOfString, ?SchemaNode $schema)
    {
        $this->name = $name;
        $this->sequenceOfString = $sequenceOfString;
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
     * @return SchemaNode|null
     */
    public function getSchema(): ?SchemaNode
    {
        return $this->schema;
    }

    /**
     * @return null|string[]
     */
    public function getSequenceOfString(): ?array
    {
        return $this->sequenceOfString;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitDependencyNode($this);
    }
}
