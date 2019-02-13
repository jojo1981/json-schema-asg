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

use Jojo1981\JsonSchemaAsg\Asg\DefinitionNode;
use Jojo1981\JsonSchemaAsg\Asg\DefinitionsNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class DefinitionsBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_DEFINITIONS];
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
        if (!empty($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new \LogicException('Expected ' . JsonKeys::KEY_DEFINITIONS . ' to have an object as value');
        }

        $definitionsNode = new DefinitionsNode($context->getParentSchemaNode());
        foreach ($value as $definitionName => $definitionObjectSchemaNode) {
            $definitionNode = new DefinitionNode($definitionsNode, $definitionName);
            $newReference = ReferenceHelper::createFromReferenceByAppendingKey($context->getParentReference(), $definitionName);
            $definitionObjectSchemaNode = $context->resolveSchemaDataRecursively($definitionObjectSchemaNode, $newReference);
            $definitionNode->setSchema($definitionObjectSchemaNode);
            $definitionsNode->addDefinitionNode($definitionNode);
        }
        $context->getParentSchemaNode()->setDefinitions($definitionsNode);
    }
}