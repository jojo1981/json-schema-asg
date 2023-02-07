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
class PatternPropertiesNode implements NodeInterface, VisitableInterface
{
    /** @var PatternPropertyNode[] */
    private array $patternProperties = [];

    /**
     * @param PatternPropertyNode[] $properties
     */
    public function __construct(array $properties = [])
    {
        $this->setPatternProperties($properties);
    }

    /**
     * @return PatternPropertyNode[]
     */
    public function getPatternProperties(): array
    {
        return $this->patternProperties;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitPatternPropertiesNode($this);
    }

    /**
     * @param PatternPropertyNode[] $patternProperties
     * @return void
     */
    private function setPatternProperties(array $patternProperties): void
    {
        $this->patternProperties = [];
        array_walk($patternProperties, [$this, 'addPatternPropertyNode']);
    }

    /**
     * @param PatternPropertyNode $propertyNode
     * @return void
     */
    private function addPatternPropertyNode(PatternPropertyNode $propertyNode): void
    {
        $this->patternProperties[] = $propertyNode;
    }
}
