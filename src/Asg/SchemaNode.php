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
use function array_walk;

/**
 * @package Jojo1981\JsonSchemaAsg\Ast
 */
abstract class SchemaNode implements NodeInterface, VisitableInterface
{
    /** @var NodeInterface[] */
    private array $parents = [];

    /** @var ReferenceNode[] */
    private array $referredBy = [];

    public function __construct(?NodeInterface $parent = null)
    {
        if (null !== $parent) {
            $this->addParent($parent);
        }
    }

    /**
     * @return NodeInterface[]
     */
    public function getParents(): array
    {
        return $this->parents;
    }

    public function setParents(array $parents): void
    {
        $this->parents = [];
        array_walk($parents, [$this, 'addParent']);
    }

    /**
     * @param null|NodeInterface $parent
     * @return void
     */
    public function addParent(?NodeInterface $parent): void
    {
        $this->parents[] = $parent;
    }

    /**
     * @param ReferenceNode[] $referredBy
     * @return void
     */
    public function setReferredBy(array $referredBy): void
    {
        $this->referredBy = [];
        array_walk($referredBy, [$this, 'addReferredBy']);
    }

    /**
     * @param ReferenceNode $reference
     * @return void
     */
    public function addReferredBy(ReferenceNode $reference): void
    {
        $this->referredBy[] = $reference;
    }

    /**
     * @return ReferenceNode[]
     */
    public function getReferredBy(): array
    {
        return $this->referredBy;
    }
}
