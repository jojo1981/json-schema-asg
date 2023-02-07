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

namespace Jojo1981\JsonSchemaAsg;

use Jojo1981\JsonSchemaAsg\Asg\NodeInterface;
use Jojo1981\JsonSchemaAsg\Value\Reference;

/**
 * @package Jojo1981\JsonSchemaAsg
 */
interface SchemaResolverInterface
{
    /**
     * @param Reference $reference
     * @return NodeInterface
     */
    public function resolveSchema(Reference $reference): NodeInterface;
}
