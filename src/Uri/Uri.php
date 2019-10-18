<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Uri;

use Jojo1981\JsonSchemaAsg\Uri\Exception\UriException;
use League\Uri\Uri as BaseUri;

/**
 * @package Jojo1981\JsonSchemaAsg\Uri
 */
class Uri implements UriInterface
{
    /** @var BaseUri */
    private $uri;

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
     * @return string
     */
    public function getUserInfo(): string
    {
        return $this->uri->getUserInfo();
    }

    /**
     * @return string
     */
    public function getHost(): string
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
     * @return string
     */
    public function getQuery(): string
    {
        return $this->uri->getQuery();
    }

    /**
     * @return string
     */
    public function getFragment(): string
    {
        return $this->uri->getFragment();
    }

    /**
     * @param string $scheme
     * @throws UriException
     * @return Uri
     */
    public function withScheme($scheme): self
    {
        try {
            return new self($this->uri->withScheme($scheme));
        } catch (\Exception $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $user
     * @param null $password
     * @throws UriException
     * @return Uri
     */
    public function withUserInfo($user, $password = null): self
    {
        try {
            return new self($this->uri->withUserInfo($user, $password));
        } catch (\Exception $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $host
     * @throws UriException
     * @return Uri
     */
    public function withHost($host): self
    {
        try {
            return new self($this->uri->withHost($host));
        } catch (\Exception $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param int|null $port
     * @throws UriException
     * @return Uri
     */
    public function withPort($port): self
    {
        try {
            return new self($this->uri->withPort($port));
        } catch (\Exception $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $path
     * @throws UriException
     * @return Uri
     */
    public function withPath($path): self
    {
        try {
            return new self($this->uri->withPath($path));
        } catch (\Exception $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $query
     * @throws UriException
     * @return Uri
     */
    public function withQuery($query): self
    {
        try {
            return new self($this->uri->withQuery($query));
        } catch (\Exception $exception) {
            throw new UriException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string $fragment
     * @throws UriException
     * @return Uri
     */
    public function withFragment($fragment): self
    {
        try {
            return new self($this->uri->withFragment($fragment));
        } catch (\Exception $exception) {
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
}