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

namespace Jojo1981\JsonSchemaAsg\Builder;

use Jojo1981\JsonSchemaAsg\Asg\RequiredNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;
use LogicException;
use function is_array;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class RequiredBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_REQUIRED];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @return void
     * @throws LogicException
     */
    protected function buildNode(string $key, mixed $value, Context $context): void
    {
        if (!is_array($value) || ArrayHelper::isAssociativeArray($value)) {
            throw new LogicException('Expected a sequence of strings');
        }
        if (!ArrayHelper::areAllArrayElementsOfType($value, 'string')) {
            throw new LogicException('Expected all values to be of type string');
        }
        $context->getParentSchemaNode()->setRequired(new RequiredNode($value));
    }
}
