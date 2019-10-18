<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg\Helper;

use Jojo1981\JsonSchemaAsg\Uri\Uri;
use Jojo1981\JsonSchemaAsg\Uri\UriInterface;
use League\Uri\Uri as BaseUri;

/**
 * @package Jojo1981\JsonSchemaAsg\Helper
 */
final class UriHelper
{
    /**
     * private constructor to prevent getting an instance of the class
     */
    private function __construct()
    {
        // Nothing to do here
    }

    /**
     * @param string $uri
     * @return UriInterface
     */
    public static function createFromString(string $uri = ''): UriInterface
    {
        return new Uri(BaseUri::createFromString($uri));
    }
}