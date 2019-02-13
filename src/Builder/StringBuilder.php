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

use Jojo1981\JsonSchemaAsg\Asg\UriNode;
use Jojo1981\JsonSchemaAsg\Value\JsonKeys;

/**
 * @package Jojo1981\JsonSchemaAsg\Builder
 */
class StringBuilder extends AbstractBuilder
{
    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return JsonKeys::getStringKeys();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @throws \LogicException
     * @return void
     */
    protected function buildNode(string $key, $value, Context $context): void
    {
        if (!\is_string($value)) {
            throw new \LogicException('Expected value to be of type string');
        }

        switch ($key) {
            case JsonKeys::KEY_ID:
                $context->getParentSchemaNode()->setId(new UriNode($context->getParentSchemaNode(), $value));
                break;
            case JsonKeys::KEY_SCHEMA:
                $context->getParentSchemaNode()->setSchema(new UriNode($context->getParentSchemaNode(), $value));
                break;
            case JsonKeys::KEY_COMMENT:
                $context->getParentSchemaNode()->setComment($value);
                break;
            case JsonKeys::KEY_VERSION:
                $context->getParentSchemaNode()->setVersion($value);
                break;
            case JsonKeys::KEY_TITLE:
                $context->getParentSchemaNode()->setTitle($value);
                break;
            case JsonKeys::KEY_DESCRIPTION:
                $context->getParentSchemaNode()->setDescription($value);
                break;
            case JsonKeys::KEY_PATTERN:
                $context->getParentSchemaNode()->setPattern($value);
                break;
            case JsonKeys::KEY_FORMAT:
                $context->getParentSchemaNode()->setFormat($value);
                break;
            case JsonKeys::KEY_CONTENT_MEDIA_TYPE:
                $context->getParentSchemaNode()->setContentMediaType($value);
                break;
            case JsonKeys::KEY_CONTENT_ENCODING:
                $context->getParentSchemaNode()->setContentEncoding($value);
                break;
        }
    }
}