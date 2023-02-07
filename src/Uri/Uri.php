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

use Jojo1981\JsonSchemaAsg\Uri\Exception\UriException;
use League\Uri\Uri as BaseUri;
use Throwable;

/**
 * @package Jojo1981\JsonSchemaAsg\Uri
 */
class Uri implements UriInterface
{
    /** @var BaseUri */
    private BaseUri $uri;

    /**
     * @param BaseUri $uri
     */
    public function __construct(BaseUri $uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->uri->getScheme();
    }

    /**
     * @return string
     */
    public function getAuthority(): string
    {
        return $this->uri->getAuthority();
    }

    /**
     * @return string|null
     */
    public function getUserInfo(): ?string
    {
        return $this->uri->getUserInfo();
    }

    /**
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->uri->getHost();
    }

    /**
     * @return null|int
     */
    public function getPort(): ?int
    {
        return $this->uri->getPort();
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->uri->getPath();
    }

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->uri->getQuery();
    }

    /**
     * @return string|null
     */
    public function getFragment(): ?string
    {
        return $this->uri->getFragment();
    }

    /**
     * @param string $scheme
     * @return Uri
     * @throws UriException
     */
    public function withScheme($scheme): UriInterface
    {
        try {
            return new self(BaseUri::createFromString((string) $this->uri->withScheme($scheme)));
        } catch (Throwable $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $user
     * @param null $password
     * @return Uri
     * @throws UriException
     */
    public function withUserInfo($user, $password = null): UriInterface
    {
        try {
            return new self(BaseUri::createFromString((string) $this->uri->withUserInfo($user, $password)));
        } catch (Throwable $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $host
     * @return Uri
     * @throws UriException
     */
    public function withHost($host): UriInterface
    {
        try {
            return new self(BaseUri::createFromString((string) $this->uri->withHost($host)));
        } catch (Throwable $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param int|null $port
     * @return Uri
     * @throws UriException
     */
    public function withPort(?int $port): UriInterface
    {
        try {
            return new self(BaseUri::createFromString((string) $this->uri->withPort($port)));
        } catch (Throwable $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $path
     * @return Uri
     * @throws UriException
     */
    public function withPath(string $path): UriInterface
    {
        try {
            return new self(BaseUri::createFromString((string) $this->uri->withPath($path)));
        } catch (Throwable $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $query
     * @return Uri
     * @throws UriException
     */
    public function withQuery($query): UriInterface
    {
        try {
            return new self(BaseUri::createFromString((string) $this->uri->withQuery($query)));
        } catch (Throwable $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string|null $fragment
     * @return Uri
     * @throws UriException
     */
    public function withFragment(?string $fragment): UriInterface
    {
        try {
            return new self(BaseUri::createFromString((string) $this->uri->withFragment($fragment)));
        } catch (Throwable $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->uri;
    }

    public function jsonSerialize(): string
    {
        return $this->uri->jsonSerialize();
    }
}
