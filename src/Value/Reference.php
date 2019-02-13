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

use Jojo1981\JsonSchemaAsg\Helper\PathHelper;
use \Jojo1981\JsonSchemaAsg\Helper\UriHelper;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;

/**
 * @package Jojo1981\JsonSchemaAsg\Value
 */
class Reference
{
    /** @var string  */
    public const FRAGMENT_SEPARATOR = '#';

    /** @var UriInterface */
    private $uri;

    /** @var JsonPointer */
    private $jsonPointer;

    /**
     * @param string $value
     * @throws \UnexpectedValueException
     */
    public function __construct(string $value)
    {
        $parts = \explode(self::FRAGMENT_SEPARATOR, $value);
        if (\count($parts) === 1) {
            $this->uri = UriHelper::createFromString($parts[0]);
            $this->jsonPointer = new JsonPointer('/');
        } elseif (\count($parts) === 2) {
            $this->uri = UriHelper::createFromString($parts[0]);
            $this->jsonPointer = new JsonPointer($parts[1]);
        }
    }

    /**
     * @return bool
     */
    public function isLocal(): bool
    {
        return '' === (string) $this->uri;
    }

    /**
     * @return bool
     */
    public function isRemote(): bool
    {
        return !$this->isLocal();
    }

    /**
     * @return bool
     */
    public function isRelativeFile(): bool
    {
        if ('' !== $this->uri->getHost()) {
            return false;
        }

        return !PathHelper::isAbsolute($this->uri->getPath());
    }

    /**
     * @return bool
     */
    public function isAbsoluteFile(): bool
    {
        if ('' !== $this->uri->getHost()) {
            return false;
        }

        return PathHelper::isAbsolute($this->uri->getPath());
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function getJsonPointer(): JsonPointer
    {
        return $this->jsonPointer;
    }

    public function getValue(): string
    {
        return $this->uri . ($this->jsonPointer ? self::FRAGMENT_SEPARATOR . $this->jsonPointer : '');
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}