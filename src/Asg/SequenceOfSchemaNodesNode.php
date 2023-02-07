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
use function array_walk;

/**
 * @package Jojo1981\JsonSchemaAsg\Ast
 */
class SequenceOfSchemaNodesNode implements NodeInterface, VisitableInterface
{
    /** @var SchemaNode[] */
    private array $schemaNodes = [];

    /**
     * @param SchemaNode[] $schemaNodes
     */
    public function __construct(array $schemaNodes = [])
    {
        $this->setSchemaNodes($schemaNodes);
    }

    /**
     * @return SchemaNode[]
     */
    public function getSchemaNodes(): array
    {
        return $this->schemaNodes;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitSequenceOfSchemaNodes($this);
    }

    /**
     * @param SchemaNode[] $schemaNodes
     * @return void
     */
    private function setSchemaNodes(array $schemaNodes): void
    {
        $this->schemaNodes = [];
        array_walk($schemaNodes, [$this, 'addSchemaNode']);
    }

    /**
     * @param SchemaNode $schemaNode
     * @return void
     */
    private function addSchemaNode(SchemaNode $schemaNode): void
    {
        $this->schemaNodes[] = $schemaNode;
    }
}
