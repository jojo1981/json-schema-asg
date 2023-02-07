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
class PropertiesNode implements NodeInterface, VisitableInterface
{
    /** @var PropertyNode[] */
    private array $properties = [];

    /**
     * @param PropertyNode[] $properties
     */
    public function __construct(array $properties = [])
    {
        $this->setProperties($properties);
    }

    /**
     * @return PropertyNode[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitPropertiesNode($this);
    }

    /**
     * @param PropertyNode[] $properties
     * @return void
     */
    private function setProperties(array $properties): void
    {
        $this->properties = [];
        array_walk($properties, [$this, 'addPropertyNode']);
    }

    /**
     * @param PropertyNode $propertyNode
     * @return void
     */
    private function addPropertyNode(PropertyNode $propertyNode): void
    {
        $this->properties[] = $propertyNode;
    }
}
