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

use InvalidArgumentException;
use Jojo1981\JsonSchemaAsg\Asg\ReferenceNode;
use Jojo1981\JsonSchemaAsg\PreProcessor\SchemaDataPreprocessor;
use Jojo1981\JsonSchemaAsg\Storage\Exception\StorageException;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;
use Jojo1981\JsonSchemaAsg\Value\Reference;
use LogicException;
use UnexpectedValueException;
use function array_key_exists;
use function is_array;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class RefBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return [JsonKeys::KEY_REF];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @return void
     * @throws StorageException
     * @throws LogicException
     * @throws UnexpectedValueException
     * @throws InvalidArgumentException
     */
    protected function buildNode(string $key, mixed $value, Context $context): void
    {
        if (!$this->hasCustomPreprocessedKeys($value)) {
            throw new LogicException('Expected value to be preprocessed and converted into an array');
        }
        $resolvedSchemaReference = new Reference($value[SchemaDataPreprocessor::CUSTOM_KEY_ABSOLUTE_REF]);

        $circular = false;
        if ($context->isCircularReference($resolvedSchemaReference)) {
            $circular = true;
        }

        if ($context->getSchemaStorage()->has($resolvedSchemaReference)) {
            $resolvedSchema = $context->getSchemaStorage()->get($resolvedSchemaReference);
        } else {
            $resolvedSchema = $context->resolveSchemaDataRecursively(
                $context->readByReference($resolvedSchemaReference),
                $resolvedSchemaReference
            );
        }

        $originalReference = $value[SchemaDataPreprocessor::CUSTOM_KEY_ORIGINAL_REF];
        $resolvedReference = $resolvedSchemaReference->getValue();
        $referenceNode = new ReferenceNode($originalReference, $resolvedReference, $circular, $resolvedSchema);

        $resolvedSchema->addReferredBy($referenceNode);
        $context->getParentSchemaNode()->setReference($referenceNode);
    }

    /**
     * Check whether the preprocessor has been used and converted the string $ref value into an array with the original
     * $ref value and the absolute reference value.
     *
     * @param mixed $value
     * @return bool
     */
    private function hasCustomPreprocessedKeys(mixed $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        return
            array_key_exists(SchemaDataPreprocessor::CUSTOM_KEY_ABSOLUTE_REF, $value) &&
            array_key_exists(SchemaDataPreprocessor::CUSTOM_KEY_ORIGINAL_REF, $value);
    }
}
