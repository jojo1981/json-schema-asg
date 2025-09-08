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

namespace Jojo1981\JsonSchemaAsg\Builder\Exception;

use LogicException;

/**
 * The base class for all exceptions thrown during the build process. The process which is responsible for building the
 * correct ASG nodes based on the json schema data
 *
 * @package Jojo1981\JsonSchemaAsg\Builder\Exception
 */
class BuilderException extends LogicException
{
    /**
     * @return BuilderException
     */
    public static function unjustifiedCallingBuilder(): BuilderException
    {
        return new self('Calling build on a builder which has not accepted the passed key');
    }
}
