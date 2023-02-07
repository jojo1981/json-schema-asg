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
class DefinitionsNode implements NodeInterface, VisitableInterface
{
    /** @var DefinitionNode[] */
    private array $definitionNodes = [];

    /**
     * @param DefinitionNode[] $definitionNodes
     */
    public function __construct(array $definitionNodes)
    {
        $this->setDefinitionNodes($definitionNodes);
    }

    /**
     * @return DefinitionNode[]
     */
    public function getDefinitionNodes(): array
    {
        return $this->definitionNodes;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitDefinitionsNode($this);
    }

    /**
     * @param DefinitionNode[] $definitionNodes
     * @return void
     */
    private function setDefinitionNodes(array $definitionNodes): void
    {
        array_walk($definitionNodes, [$this, "addDefinitionNode"]);
    }

    /**
     * @param DefinitionNode $definitionNode
     * @return void
     */
    private function addDefinitionNode(DefinitionNode $definitionNode): void
    {
        $this->definitionNodes[] = $definitionNode;
    }
}
