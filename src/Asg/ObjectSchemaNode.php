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

namespace Jojo1981\JsonSchemaAsg\Asg;

use Jojo1981\JsonSchemaAsg\Visitor\VisitorInterface;

/**
 * @package Jojo1981\JsonSchemaAsg\Ast
 */
class ObjectSchemaNode extends SchemaNode
{
    /** @var null|ReferenceNode */
    private ?ReferenceNode $reference = null;

    /** @var null|UriNode */
    private ?UriNode $id = null;

    /** @var null|UriNode */
    private ?UriNode $schema = null;

    /** @var null|string */
    private ?string $comment = null;

    /** @var null|string */
    private ?string $version = null;

    /** @var null|string */
    private ?string $title = null;

    /** @var null|string */
    private ?string $description = null;

    /** @var null|string */
    private ?string $pattern = null;

    /** @var null|string */
    private ?string $format = null;

    /** @var null|string */
    private ?string $contentMediaType = null;

    /** @var null|string */
    private ?string $contentEncoding = null;

    /** @var null|SimpleTypesSequenceNode */
    private ?SimpleTypesSequenceNode $type = null;

    /** @var null|RequiredNode */
    private ?RequiredNode $required = null;

    /** @var null|PropertiesNode */
    private ?PropertiesNode $properties = null;

    /** @var null|PatternPropertiesNode */
    private ?PatternPropertiesNode $patternProperties = null;

    /** @var null|DefinitionsNode */
    private ?DefinitionsNode $definitions = null;

    /** @var null|float */
    private ?float $multipleOf = null;

    /** @var null|ItemsNode */
    private ?ItemsNode $items = null;

    /** @var null|EnumNode */
    private ?EnumNode $enum = null;

    /** @var null|bool */
    private ?bool $readOnly = null;

    /** @var null|int */
    private ?int $maxLength = null;

    /** @var null|int */
    private ?int $minLength = null;

    /** @var null|int */
    private ?int $maxItems = null;

    /** @var null|int */
    private ?int $minItems = null;

    /** @var null|int */
    private ?int $maxProperties = null;

    /** @var null|int */
    private ?int $minProperties = null;

    /** @var null|bool */
    private ?bool $uniqueItems = null;

    /** @var null|float */
    private ?float $maximum = null;

    /** @var null|float */
    private ?float $exclusiveMaximum = null;

    /** @var null|float */
    private ?float $minimum = null;

    /** @var null|float */
    private ?float $exclusiveMinimum = null;

    /** @var null|SchemaNode */
    private ?SchemaNode $additionalItems = null;

    /** @var null|SchemaNode */
    private ?SchemaNode $contains = null;

    /** @var null|SchemaNode */
    private ?SchemaNode $additionalProperties = null;

    /** @var null|SchemaNode */
    private ?SchemaNode $propertyNames = null;

    /** @var null|SchemaNode */
    private ?SchemaNode $if = null;

    /** @var null|SchemaNode */
    private ?SchemaNode $then = null;

    /** @var null|SchemaNode */
    private ?SchemaNode $else = null;

    /** @var null|SchemaNode */
    private ?SchemaNode $not = null;

    /** @var null|SequenceOfSchemaNodesNode */
    private ?SequenceOfSchemaNodesNode $allOf = null;

    /** @var null|SequenceOfSchemaNodesNode */
    private ?SequenceOfSchemaNodesNode $anyOf = null;

    /** @var null|SequenceOfSchemaNodesNode */
    private ?SequenceOfSchemaNodesNode $oneOf = null;

    /** @var null|array */
    private ?array $examples = null;

    /** @var null|DependenciesNode */
    private ?DependenciesNode $dependencies = null;

    /** @var null|array */
    private ?array $extraData = null;

    /** @var mixed */
    private mixed $const = null;

    /** @var mixed */
    private mixed $default = null;

    /**
     * @return null|ReferenceNode
     */
    public function getReference(): ?ReferenceNode
    {
        return $this->reference;
    }

    /**
     * @param null|ReferenceNode $reference
     * @return void
     */
    public function setReference(?ReferenceNode $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return null|UriNode
     */
    public function getId(): ?UriNode
    {
        return $this->id;
    }

    /**
     * @param null|UriNode $id
     * @return void
     */
    public function setId(?UriNode $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null|UriNode
     */
    public function getSchema(): ?UriNode
    {
        return $this->schema;
    }

    /**
     * @param null|UriNode $schema
     * @return void
     */
    public function setSchema(?UriNode $schema): void
    {
        $this->schema = $schema;
    }

    /**
     * @return null|string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param null|string $comment
     * @return void
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return null|string
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @param null|string $version
     * @return void
     */
    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     * @return void
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return null|string
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * @param null|string $pattern
     * @return void
     */
    public function setPattern(?string $pattern): void
    {
        $this->pattern = $pattern;
    }

    /**
     * @return null|string
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @param null|string $format
     * @return void
     */
    public function setFormat(?string $format): void
    {
        $this->format = $format;
    }

    /**
     * @return null|string
     */
    public function getContentMediaType(): ?string
    {
        return $this->contentMediaType;
    }

    /**
     * @param null|string $contentMediaType
     * @return void
     */
    public function setContentMediaType(?string $contentMediaType): void
    {
        $this->contentMediaType = $contentMediaType;
    }

    /**
     * @return null|string
     */
    public function getContentEncoding(): ?string
    {
        return $this->contentEncoding;
    }

    /**
     * @param null|string $contentEncoding
     * @return void
     */
    public function setContentEncoding(?string $contentEncoding): void
    {
        $this->contentEncoding = $contentEncoding;
    }

    /**
     * @return null|SimpleTypesSequenceNode
     */
    public function getType(): ?SimpleTypesSequenceNode
    {
        return $this->type;
    }

    /**
     * @param null|SimpleTypesSequenceNode $type
     * @return void
     */
    public function setType(?SimpleTypesSequenceNode $type): void
    {
        $this->type = $type;
    }

    /**
     * @return null|RequiredNode
     */
    public function getRequired(): ?RequiredNode
    {
        return $this->required;
    }

    /**
     * @param null|RequiredNode $required
     * @return void
     */
    public function setRequired(?RequiredNode $required): void
    {
        $this->required = $required;
    }

    /**
     * @return null|PropertiesNode
     */
    public function getProperties(): ?PropertiesNode
    {
        return $this->properties;
    }

    /**
     * @param null|PropertiesNode $properties
     * @return void
     */
    public function setProperties(?PropertiesNode $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @return null|PatternPropertiesNode
     */
    public function getPatternProperties(): ?PatternPropertiesNode
    {
        return $this->patternProperties;
    }

    /**
     * @param null|PatternPropertiesNode $patternProperties
     * @return void
     */
    public function setPatternProperties(?PatternPropertiesNode $patternProperties): void
    {
        $this->patternProperties = $patternProperties;
    }

    /**
     * @return null|DefinitionsNode
     */
    public function getDefinitions(): ?DefinitionsNode
    {
        return $this->definitions;
    }

    /**
     * @param null|DefinitionsNode $definitions
     * @return void
     */
    public function setDefinitions(?DefinitionsNode $definitions): void
    {
        $this->definitions = $definitions;
    }

    /**
     * @return null|float
     */
    public function getMultipleOf(): ?float
    {
        return $this->multipleOf;
    }

    /**
     * @param null|float $multipleOf
     * @return void
     */
    public function setMultipleOf(?float $multipleOf): void
    {
        $this->multipleOf = $multipleOf;
    }

    /**
     * @return null|ItemsNode
     */
    public function getItems(): ?ItemsNode
    {
        return $this->items;
    }

    /**
     * @param null|ItemsNode $items
     * @return void
     */
    public function setItems(?ItemsNode $items): void
    {
        $this->items = $items;
    }

    /**
     * @return null|EnumNode
     */
    public function getEnum(): ?EnumNode
    {
        return $this->enum;
    }

    /**
     * @param null|EnumNode $enum
     * @return void
     */
    public function setEnum(?EnumNode $enum): void
    {
        $this->enum = $enum;
    }

    /**
     * @return null|bool
     */
    public function getReadOnly(): ?bool
    {
        return $this->readOnly;
    }

    /**
     * @param null|bool $readOnly
     * @return void
     */
    public function setReadOnly(?bool $readOnly): void
    {
        $this->readOnly = $readOnly;
    }

    /**
     * @return null|int
     */
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    /**
     * @param null|int $maxLength
     * @return void
     */
    public function setMaxLength(?int $maxLength): void
    {
        $this->maxLength = $maxLength;
    }

    /**
     * @return null|int
     */
    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    /**
     * @param null|int $minLength
     * @return void
     */
    public function setMinLength(?int $minLength): void
    {
        $this->minLength = $minLength;
    }

    /**
     * @return null|int
     */
    public function getMaxItems(): ?int
    {
        return $this->maxItems;
    }

    /**
     * @param null|int $maxItems
     * @return void
     */
    public function setMaxItems(?int $maxItems): void
    {
        $this->maxItems = $maxItems;
    }

    /**
     * @return null|int
     */
    public function getMinItems(): ?int
    {
        return $this->minItems;
    }

    /**
     * @param null|int $minItems
     * @return void
     */
    public function setMinItems(?int $minItems): void
    {
        $this->minItems = $minItems;
    }

    /**
     * @return null|int
     */
    public function getMaxProperties(): ?int
    {
        return $this->maxProperties;
    }

    /**
     * @param null|int $maxProperties
     * @return void
     */
    public function setMaxProperties(?int $maxProperties): void
    {
        $this->maxProperties = $maxProperties;
    }

    /**
     * @return null|int
     */
    public function getMinProperties(): ?int
    {
        return $this->minProperties;
    }

    /**
     * @param null|int $minProperties
     * @return void
     */
    public function setMinProperties(?int $minProperties): void
    {
        $this->minProperties = $minProperties;
    }

    /**
     * @return null|bool
     */
    public function getUniqueItems(): ?bool
    {
        return $this->uniqueItems;
    }

    /**
     * @param null|bool $uniqueItems
     * @return void
     */
    public function setUniqueItems(?bool $uniqueItems): void
    {
        $this->uniqueItems = $uniqueItems;
    }

    /**
     * @return null|float
     */
    public function getMaximum(): ?float
    {
        return $this->maximum;
    }

    /**
     * @param null|float $maximum
     * @return void
     */
    public function setMaximum(?float $maximum): void
    {
        $this->maximum = $maximum;
    }

    /**
     * @return null|float
     */
    public function getExclusiveMaximum(): ?float
    {
        return $this->exclusiveMaximum;
    }

    /**
     * @param null|float $exclusiveMaximum
     * @return void
     */
    public function setExclusiveMaximum(?float $exclusiveMaximum): void
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
    }

    /**
     * @return null|float
     */
    public function getMinimum(): ?float
    {
        return $this->minimum;
    }

    /**
     * @param null|float $minimum
     * @return void
     */
    public function setMinimum(?float $minimum): void
    {
        $this->minimum = $minimum;
    }

    /**
     * @return null|float
     */
    public function getExclusiveMinimum(): ?float
    {
        return $this->exclusiveMinimum;
    }

    /**
     * @param null|float $exclusiveMinimum
     * @return void
     */
    public function setExclusiveMinimum(?float $exclusiveMinimum): void
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
    }

    /**
     * @return null|SchemaNode
     */
    public function getAdditionalItems(): ?SchemaNode
    {
        return $this->additionalItems;
    }

    /**
     * @param null|SchemaNode $additionalItems
     * @return void
     */
    public function setAdditionalItems(?SchemaNode $additionalItems): void
    {
        $this->additionalItems = $additionalItems;
    }

    /**
     * @return null|SchemaNode
     */
    public function getContains(): ?SchemaNode
    {
        return $this->contains;
    }

    /**
     * @param null|SchemaNode $contains
     * @return void
     */
    public function setContains(?SchemaNode $contains): void
    {
        $this->contains = $contains;
    }

    /**
     * @return null|SchemaNode
     */
    public function getAdditionalProperties(): ?SchemaNode
    {
        return $this->additionalProperties;
    }

    /**
     * @param null|SchemaNode $additionalProperties
     * @return void
     */
    public function setAdditionalProperties(?SchemaNode $additionalProperties): void
    {
        $this->additionalProperties = $additionalProperties;
    }

    /**
     * @return null|SchemaNode
     */
    public function getPropertyNames(): ?SchemaNode
    {
        return $this->propertyNames;
    }

    /**
     * @param null|SchemaNode $propertyNames
     * @return void
     */
    public function setPropertyNames(?SchemaNode $propertyNames): void
    {
        $this->propertyNames = $propertyNames;
    }

    /**
     * @return null|SchemaNode
     */
    public function getIf(): ?SchemaNode
    {
        return $this->if;
    }

    /**
     * @param null|SchemaNode $if
     * @return void
     */
    public function setIf(?SchemaNode $if): void
    {
        $this->if = $if;
    }

    /**
     * @return null|SchemaNode
     */
    public function getThen(): ?SchemaNode
    {
        return $this->then;
    }

    /**
     * @param null|SchemaNode $then
     * @return void
     */
    public function setThen(?SchemaNode $then): void
    {
        $this->then = $then;
    }

    /**
     * @return null|SchemaNode
     */
    public function getElse(): ?SchemaNode
    {
        return $this->else;
    }

    /**
     * @param null|SchemaNode $else
     * @return void
     */
    public function setElse(?SchemaNode $else): void
    {
        $this->else = $else;
    }

    /**
     * @return null|SchemaNode
     */
    public function getNot(): ?SchemaNode
    {
        return $this->not;
    }

    /**
     * @param null|SchemaNode $not
     * @return void
     */
    public function setNot(?SchemaNode $not): void
    {
        $this->not = $not;
    }

    /**
     * @return null|SequenceOfSchemaNodesNode
     */
    public function getAllOf(): ?SequenceOfSchemaNodesNode
    {
        return $this->allOf;
    }

    /**
     * @param null|SequenceOfSchemaNodesNode $allOf
     * @return void
     */
    public function setAllOf(?SequenceOfSchemaNodesNode $allOf): void
    {
        $this->allOf = $allOf;
    }

    /**
     * @return null|SequenceOfSchemaNodesNode
     */
    public function getAnyOf(): ?SequenceOfSchemaNodesNode
    {
        return $this->anyOf;
    }

    /**
     * @param null|SequenceOfSchemaNodesNode $anyOf
     * @return void
     */
    public function setAnyOf(?SequenceOfSchemaNodesNode $anyOf): void
    {
        $this->anyOf = $anyOf;
    }

    /**
     * @return null|SequenceOfSchemaNodesNode
     */
    public function getOneOf(): ?SequenceOfSchemaNodesNode
    {
        return $this->oneOf;
    }

    /**
     * @param null|SequenceOfSchemaNodesNode $oneOf
     * @return void
     */
    public function setOneOf(?SequenceOfSchemaNodesNode $oneOf): void
    {
        $this->oneOf = $oneOf;
    }

    /**
     * @return null|array
     */
    public function getExamples(): ?array
    {
        return $this->examples;
    }

    /**
     * @param array $examples
     * @return void
     */
    public function setExamples(array $examples): void
    {
        $this->examples = $examples;
    }

    /**
     * @return null|DependenciesNode
     */
    public function getDependencies(): ?DependenciesNode
    {
        return $this->dependencies;
    }

    /**
     * @param null|DependenciesNode $dependencies
     * @return void
     */
    public function setDependencies(?DependenciesNode $dependencies): void
    {
        $this->dependencies = $dependencies;
    }

    /**
     * @return null|array
     */
    public function getExtraData(): ?array
    {
        return $this->extraData;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addExtraData(string $key, mixed $value): void
    {
        if (null === $this->extraData) {
            $this->extraData = [];
        }

        $this->extraData[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getConst(): mixed
    {
        return $this->const;
    }

    /**
     * @param mixed $const
     * @return void
     */
    public function setConst(mixed $const): void
    {
        $this->const = $const;
    }

    /**
     * @return mixed
     */
    public function getDefault(): mixed
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     * @return void
     */
    public function setDefault(mixed $default): void
    {
        $this->default = $default;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor): mixed
    {
        return $visitor->visitObjectSchemaNode($this);
    }
}
