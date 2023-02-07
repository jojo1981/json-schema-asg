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

use Jojo1981\JsonSchemaAsg\Asg\PatternPropertiesNode;
use Jojo1981\JsonSchemaAsg\Asg\PatternPropertyNode;
use Jojo1981\JsonSchemaAsg\Helper\ArrayHelper;
use Jojo1981\JsonSchemaAsg\Helper\ReferenceHelper;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;
use LogicException;
use UnexpectedValueException;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class PatternPropertiesBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_PATTERN_PROPERTIES];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @return void
     * @throws UnexpectedValueException
     * @throws LogicException
     */
    protected function buildNode(string $key, mixed $value, Context $context): void
    {
        if (!empty($value) && !ArrayHelper::isAssociativeArray($value)) {
            throw new LogicException('Expected pattern properties to have an object as value');
        }

        $patternPropertiesNodes = [];
        foreach ($value as $propertyPattern => $propertySchemaData) {
            $newReference = ReferenceHelper::createFromReferenceByAppendingKey($context->getParentReference(), $propertyPattern);
            $propertyObjectSchemaNode = $context->resolveSchemaDataRecursively($propertySchemaData, $newReference);
            $patternPropertiesNodes[] = new PatternPropertyNode($propertyPattern, $propertyObjectSchemaNode);
        }
        $context->getParentSchemaNode()->setPatternProperties(new PatternPropertiesNode($patternPropertiesNodes));
    }
}
