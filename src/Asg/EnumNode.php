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
class EnumNode implements NodeInterface, VisitableInterface
{
    /** @var string[] */
    private array $values = [];

    /**
     * @param string[] $values
     */
    public function __construct(array $values = [])
    {
        $this->setValues($values);
    }

    /**
     * @return string[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitEnumNode($this);
    }

    /**
     * @param string[] $values
     * @return void
     */
    private function setValues(array $values): void
    {
        $this->values = [];
        array_walk($values, [$this, 'addValue']);
    }

    /**
     * @param string $value
     * @return void
     */
    private function addValue(string $value): void
    {
        $this->values[] = $value;
    }
}
