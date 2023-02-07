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
class ItemsNode implements NodeInterface, VisitableInterface
{
    /** @var SchemaNode[] */
    private array $schemas = [];

    /**
     * @param SchemaNode[] $schemas
     */
    public function __construct(array $schemas)
    {
        $this->setSchemas($schemas);
    }

    /**
     * @return SchemaNode[]
     */
    public function getSchemas(): array
    {
        return $this->schemas;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitItemsNode($this);
    }

    /**
     * @param SchemaNode[] $schemas
     * @return void
     */
    private function setSchemas(array $schemas): void
    {
        $this->schemas = [];
        array_walk($schemas, [$this, 'addSchema']);
    }

    /**
     * @param SchemaNode $schemaNode
     * @return void
     */
    private function addSchema(SchemaNode $schemaNode): void
    {
        $this->schemas[] = $schemaNode;
    }
}
