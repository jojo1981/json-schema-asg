<?php
/*
 * This file is part of the jojo1981/json-schema-asg package
 *
 * Copyright (c) 2019 Joost Nijhuis <jnijhuis81@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 */
namespace Jojo1981\JsonSchemaAsg;

use Jojo1981\JsonSchemaAsg\Builder\BooleanBuilder;
use Jojo1981\JsonSchemaAsg\Builder\BuilderInterface;
use Jojo1981\JsonSchemaAsg\Builder\Context;
use Jojo1981\JsonSchemaAsg\Builder\DefinitionsBuilder;
use Jojo1981\JsonSchemaAsg\Builder\DependenciesBuilder;
use Jojo1981\JsonSchemaAsg\Builder\DirectSchemaBuilder;
use Jojo1981\JsonSchemaAsg\Builder\EnumBuilder;
use Jojo1981\JsonSchemaAsg\Builder\ExamplesBuilder;
use Jojo1981\JsonSchemaAsg\Builder\Exception\BuilderException;
use Jojo1981\JsonSchemaAsg\Builder\ExtraDataBuilder;
use Jojo1981\JsonSchemaAsg\Builder\IntegerBuilder;
use Jojo1981\JsonSchemaAsg\Builder\ItemsBuilder;
use Jojo1981\JsonSchemaAsg\Builder\MixedBuilder;
use Jojo1981\JsonSchemaAsg\Builder\NumberBuilder;
use Jojo1981\JsonSchemaAsg\Builder\PatternPropertiesBuilder;
use Jojo1981\JsonSchemaAsg\Builder\PropertiesBuilder;
use Jojo1981\JsonSchemaAsg\Builder\RefBuilder;
use Jojo1981\JsonSchemaAsg\Builder\RequiredBuilder;
use Jojo1981\JsonSchemaAsg\Builder\SequenceOfSchemasBuilder;
use Jojo1981\JsonSchemaAsg\Builder\StringBuilder;
use Jojo1981\JsonSchemaAsg\Builder\TypeBuilder;

/**
 * This class is a registry for builders but is a builder itself and will delegate the build process to the builder
 * which has claimed it can build a certain node. Nodes are identifier by the `key` which is found in the json schema
 * data. Only one builder can claim to be the builder for a certain key. Builders can claim multiple keys.
 *
 * @package Jojo1981\JsonSchemaAsg
 */
class BuilderRegistry implements BuilderInterface
{
    /** @var string */
    public const WILDCARD_SYMBOL = '*';

    /** @var BuilderInterface[] */
    private $builders = [];

    /**
     * @param BuilderInterface[] $builders
     */
    public function __construct(array $builders = [])
    {
        $this->setBuilders($builders);
    }

    /**
     * @param BuilderInterface[] $builders
     * @return void
     */
    public function setBuilders(array $builders): void
    {
        \array_walk($builders, [$this, 'addBuilder']);
    }

    /**
     * @param BuilderInterface $builder
     * @throws \LogicException
     * @return void
     */
    public function addBuilder(BuilderInterface $builder): void
    {
        foreach ($builder->getAcceptedKeys() as $key) {
            if (\array_key_exists($key, $this->builders)) {
                throw new \LogicException('Only one builder for a certain key kan be added');
            }
            $this->builders[$key] = $builder;
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasBuilderForKey(string $key): bool
    {
        return \array_key_exists($key, $this->builders);
    }

    /**
     * @param string $key
     * @throws \LogicException
     * @return bool
     */
    public function removeBuilderForKey(string $key): bool
    {
        if (!$this->hasBuilderForKey($key)) {
            throw new \LogicException(\sprintf(
                'Trying to remove builder for key: %s, but there isn\'t a builder registered for that key',
                $key
            ));
        }

        unset($this->builders[$key]);
    }

    /**
     * @return string[]
     */
    public function getAcceptedKeys(): array
    {
        return \array_keys($this->builders);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function acceptKey(string $key): bool
    {
        return \in_array($key, $this->getAcceptedKeys(), true)
            || \in_array(self::WILDCARD_SYMBOL, $this->getAcceptedKeys(), true);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param Context $context
     * @throws BuilderException
     * @return void
     */
    public function build(string $key, $value, Context $context): void
    {
        if (\array_key_exists($key, $this->builders)) {
            $this->builders[$key]->build($key, $value, $context);
            return;
        }
        if (\array_key_exists(self::WILDCARD_SYMBOL, $this->builders)) {
            $this->builders[self::WILDCARD_SYMBOL]->build($key, $value, $context);
            return;
        }

        throw BuilderException::unjustifiedCallingBuilder();
    }

    /**
     * @throws \LogicException
     * @return BuilderRegistry
     */
    public static function createDefaultBuilderRegistry(): BuilderRegistry
    {
        $builderRegistry = new BuilderRegistry();
        $builderRegistry->addBuilder(new RefBuilder());
        $builderRegistry->addBuilder(new TypeBuilder());
        $builderRegistry->addBuilder(new DefinitionsBuilder());
        $builderRegistry->addBuilder(new RequiredBuilder());
        $builderRegistry->addBuilder(new PropertiesBuilder());
        $builderRegistry->addBuilder(new PatternPropertiesBuilder());
        $builderRegistry->addBuilder(new ItemsBuilder());
        $builderRegistry->addBuilder(new EnumBuilder());
        $builderRegistry->addBuilder(new BooleanBuilder());
        $builderRegistry->addBuilder(new StringBuilder());
        $builderRegistry->addBuilder(new NumberBuilder());
        $builderRegistry->addBuilder(new IntegerBuilder());
        $builderRegistry->addBuilder(new DirectSchemaBuilder());
        $builderRegistry->addBuilder(new ExamplesBuilder());
        $builderRegistry->addBuilder(new DependenciesBuilder());
        $builderRegistry->addBuilder(new ExtraDataBuilder());
        $builderRegistry->addBuilder(new SequenceOfSchemasBuilder());
        $builderRegistry->addBuilder(new MixedBuilder());

        return $builderRegistry;
    }
}