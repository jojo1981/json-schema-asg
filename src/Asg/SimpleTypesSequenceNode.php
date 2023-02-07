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
class SimpleTypesSequenceNode implements NodeInterface, VisitableInterface
{
    /** @var SimpleTypeNode[] */
    private array $simpleTypeNodes = [];

    /**
     * @param SimpleTypeNode[] $simpleTypeNodes
     */
    public function __construct(array $simpleTypeNodes = [])
    {
        $this->setSimpleTypeNodes($simpleTypeNodes);
    }

    /**
     * @return SimpleTypeNode[]
     */
    public function getSimpleTypeNodes(): array
    {
        return $this->simpleTypeNodes;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitSimpleTypesSequenceNode($this);
    }

    /**
     * @param SimpleTypeNode[] $simpleTypeNodes
     * @return void
     */
    private function setSimpleTypeNodes(array $simpleTypeNodes): void
    {
        $this->simpleTypeNodes = [];
        array_walk($simpleTypeNodes, [$this, 'addSimpleTypeNode']);
    }

    /**
     * @param SimpleTypeNode $simpleTypeNode
     * @return void
     */
    private function addSimpleTypeNode(SimpleTypeNode $simpleTypeNode): void
    {
        $this->simpleTypeNodes[] = $simpleTypeNode;
    }
}
