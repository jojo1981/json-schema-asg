<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg;

use Jojo1981\JsonSchemaAsg\Value\Reference;

/**
 * The reference resolver is responsible for getting the raw json data and return a sub part from it according the
 * json pointer in the passed reference.
 *
 * @package Jojo1981\JsonSchemaAsg
 */
interface ReferenceResolverInterface
{
    /**
     * Get schema data by reference and return the json sub node according the json pointer reference tokens.
     *
     * @param Reference $reference
     * @return bool|array|array[]
     */
    public function readByReference(Reference $reference);
}