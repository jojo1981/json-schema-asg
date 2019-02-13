<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Builder;

use Jojo1981\JsonSchemaAsg\Asg\ItemsNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class ItemsBuilder extends AbstractBuilder
{
    /**
     * @return array
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_ITEMS];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @throws \LogicException
     * @throws \UnexpectedValueException
     * @return void
     */
    protected function buildNode(string $key, $value, Context $context): void
    {
        if (!\is_bool($value) && !\is_array($value)) {
            throw new \LogicException('Expected value of items to be a schema or a sequence of schemas');
        }
        if (\is_array($value) && empty($value)) {
            throw new \LogicException('Expected value of items to not to be an empty object');
        }

        $itemsNode = new ItemsNode($context->getParentSchemaNode());
        if (\is_bool($value) || ArrayHelper::isAssociativeArray($value)) {
            // single schema found
            $itemsNode->addSchema($context->resolveSchemaDataRecursively($value, $context->getParentReference()));
        } else {
            // sequence of schemas
            foreach ($value as $index => $itemSchema) {
                $newReference = ReferenceHelper::createFromReferenceByAppendingKey($context->getParentReference(), $index);
                $itemsNode->addSchema($context->resolveSchemaDataRecursively($itemSchema, $newReference));
            }
        }

        $context->getParentSchemaNode()->setItems($itemsNode);
    }
}