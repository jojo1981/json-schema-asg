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

/***
 * @package Jojo1981\JsonSchemaAsg\Ast
 */
class ReferenceNode implements NodeInterface, VisitableInterface
{
    /** @var string */
    private string $originalReference;

    /** @var string */
    private string $resolvedReference;

    /** @var bool */
    private bool $circular;

    /** @var SchemaNode */
    private SchemaNode $pointToSchema;

    /**
     * @param string $originalReference
     * @param string $resolvedReference
     * @param bool $circular
     * @param SchemaNode $pointToSchema
     */
    public function __construct(string $originalReference, string $resolvedReference, bool $circular, SchemaNode $pointToSchema)
    {
        $this->originalReference = $originalReference;
        $this->resolvedReference = $resolvedReference;
        $this->circular = $circular;
        $this->pointToSchema = $pointToSchema;
    }

    /**
     * @return string
     */
    public function getOriginalReference(): string
    {
        return $this->originalReference;
    }

    /**
     * @return string
     */
    public function getResolvedReference(): string
    {
        return $this->resolvedReference;
    }

    /**
     * @return bool
     */
    public function isCircular(): bool
    {
        return $this->circular;
    }

    /**
     * @return SchemaNode
     */
    public function getPointToSchema(): SchemaNode
    {
        return $this->pointToSchema;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitReferenceNode($this);
    }
}
