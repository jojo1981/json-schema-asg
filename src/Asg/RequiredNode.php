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
class RequiredNode implements NodeInterface, VisitableInterface
{
    /** @var string[] */
    private array $propertyNames = [];

    /**
     * @param string[] $propertyNames
     */
    public function __construct(array $propertyNames)
    {
        $this->setPropertyNames($propertyNames);
    }

    /***
     * @return string[]
     */
    public function getPropertyNames(): array
    {
        return $this->propertyNames;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitRequiredNode($this);
    }

    /**
     * @param string[] $propertyNames
     * @return void
     */
    private function setPropertyNames(array $propertyNames): void
    {
        $this->propertyNames = [];
        array_walk($propertyNames, [$this, 'addPropertyName']);
    }

    /**
     * @param string $propertyName
     * @return void
     */
    private function addPropertyName(string $propertyName): void
    {
        $this->propertyNames[] = $propertyName;
    }
}
