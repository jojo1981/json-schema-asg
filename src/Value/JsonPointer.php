<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Value;

use Jojo1981\JsonSchemaAsg\Helper\ReferenceTokenParser;

/**
 * @package Jojo1981\JsonSchemaAsg\Value
 */
class JsonPointer
{
    /** @var string */
    public const REFERENCE_TOKEN_SEPARATOR = '/';

    /** @var string[] */
    private $referenceTokens;

    /**
     * @param string $value
     * @throws \UnexpectedValueException
     */
    public function __construct(string $value)
    {
        $this->assertValue($value);
        $this->referenceTokens = $this->buildReferenceTokens($value);
    }

    /**
     * @return string[]
     */
    public function getReferenceTokens(): array
    {
        return $this->referenceTokens;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return '/' . \implode(
            self::REFERENCE_TOKEN_SEPARATOR,
            ReferenceTokenParser::denormalizeReferenceTokens($this->referenceTokens)
        );
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

    /**
     * @param string $value
     * @throws \UnexpectedValueException
     */
    private function assertValue(string $value): void
    {
        if (0 !== \strpos($value, '/')) {
            throw new \UnexpectedValueException(\sprintf('Invalid json pointer with value: `%s` passed.', $value));
        }
    }

    /**
     * @param string $value
     * @return string[]
     */
    private function buildReferenceTokens(string $value): array
    {
        if (self::REFERENCE_TOKEN_SEPARATOR === $value) {
            return [];
        }

        return ReferenceTokenParser::normalizeReferenceTokens(\explode('/', \substr($value, 1)));
    }
}