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
class DependenciesNode implements NodeInterface, VisitableInterface
{
    /** @var ObjectSchemaNode */
    private ObjectSchemaNode $parent;

    /** @var DependenciesNode[] */
    private array $dependencyNodes = [];

    /**
     * @param DependencyNode[] $dependencyNodes
     */
    public function __construct(array $dependencyNodes)
    {
        $this->setDependencyNodes($dependencyNodes);
    }

    /**
     * @return DependencyNode[]
     */
    public function getDependencyNodes(): array
    {
        return $this->dependencyNodes;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitDependenciesNode($this);
    }

    /**
     * @param DependencyNode[] $dependencyNodes
     * @return void
     */
    private function setDependencyNodes(array $dependencyNodes): void
    {
        array_walk($dependencyNodes, [$this, "addDependencyNode"]);
    }

    /**
     * @param DependencyNode $dependencyNode
     * @return void
     */
    private function addDependencyNode(DependencyNode $dependencyNode): void
    {
        $this->dependencyNodes[] = $dependencyNode;
    }
}
