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

namespace Jojo1981\JsonSchemaAsg\Uri;

use Jojo1981\JsonSchemaAsg\Uri\Exception\PathException;
use League\Uri\Components\Path as BasePath;
use League\Uri\Contracts\UriComponentInterface;
use Throwable;

/**
 * @package Jojo1981\JsonSchemaAsg\Uri
 */
class Path implements PathInterface
{
    /** @var BasePath */
    private BasePath $path;

    /**
     * @param string $path
     */
    public function __construct(string $path = '')
    {
        $this->path = new BasePath($path);
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->path->getContent();
    }

    /**
     * @return string
     */
    public function getUriComponent(): string
    {
        return $this->path->getUriComponent();
    }

    /**
     * @return string
     */
    public function decoded(): string
    {
        return $this->path->decoded();
    }

    /**
     * @return bool
     */
    public function isAbsolute(): bool
    {
        return $this->path->isAbsolute();
    }

    /**
     * @return bool
     */
    public function hasTrailingSlash(): bool
    {
        return $this->path->hasTrailingSlash();
    }

    /**
     * @param string|null $content
     * @return UriComponentInterface
     * @throws PathException
     */
    public function withContent(?string $content): UriComponentInterface
    {
        try {
            return $this->path->withContent($content);
        } catch (Throwable $exception) {
            throw new PathException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return PathInterface
     * @throws PathException
     */
    public function withoutDotSegments(): PathInterface
    {
        try {
            return new self($this->path->withoutDotSegments()->decoded());
        } catch (Throwable $exception) {
            throw new PathException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return PathInterface
     * @throws PathException
     */
    public function withTrailingSlash(): PathInterface
    {
        try {
            return new self($this->path->withTrailingSlash()->decoded());
        } catch (Throwable $exception) {
            throw new PathException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return PathInterface
     * @throws PathException
     */
    public function withoutTrailingSlash(): PathInterface
    {
        try {
            return new self($this->path->withoutTrailingSlash()->decoded());
        } catch (Throwable $exception) {
            throw new PathException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return PathInterface
     * @throws PathException
     */
    public function withLeadingSlash(): PathInterface
    {
        try {
            return new self($this->path->withLeadingSlash()->decoded());
        } catch (Throwable $exception) {
            throw new PathException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return PathInterface
     * @throws PathException
     */
    public function withoutLeadingSlash(): PathInterface
    {
        try {
            return new self($this->path->withoutLeadingSlash()->decoded());
        } catch (Throwable $exception) {
            throw new PathException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return string|null
     */
    public function jsonSerialize(): ?string
    {
        return $this->path->jsonSerialize();
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->path->toString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->path->__toString();
    }
}
