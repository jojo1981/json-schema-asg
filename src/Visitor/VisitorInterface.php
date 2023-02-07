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

namespace Jojo1981\JsonSchemaAsg\Visitor;

use Jojo1981\JsonSchemaAsg\Asg\BooleanSchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\DefinitionNode;
use Jojo1981\JsonSchemaAsg\Asg\DefinitionsNode;
use Jojo1981\JsonSchemaAsg\Asg\DependenciesNode;
use Jojo1981\JsonSchemaAsg\Asg\DependencyNode;
use Jojo1981\JsonSchemaAsg\Asg\EmptySchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\EnumNode;
use Jojo1981\JsonSchemaAsg\Asg\ItemsNode;
use Jojo1981\JsonSchemaAsg\Asg\ObjectSchemaNode;
use Jojo1981\JsonSchemaAsg\Asg\PatternPropertiesNode;
use Jojo1981\JsonSchemaAsg\Asg\PatternPropertyNode;
use Jojo1981\JsonSchemaAsg\Asg\PropertiesNode;
use Jojo1981\JsonSchemaAsg\Asg\PropertyNode;
use Jojo1981\JsonSchemaAsg\Asg\ReferenceNode;
use Jojo1981\JsonSchemaAsg\Asg\RequiredNode;
use Jojo1981\JsonSchemaAsg\Asg\SequenceOfSchemaNodesNode;
use Jojo1981\JsonSchemaAsg\Asg\SimpleTypeNode;
use Jojo1981\JsonSchemaAsg\Asg\SimpleTypesSequenceNode;
use Jojo1981\JsonSchemaAsg\Asg\UriNode;

/**
 * This visitor interface describes all the nodes of the ASG which should be visitable
 *
 * @package Jojo1981\JsonSchemaAsg\Visitor
 */
interface VisitorInterface
{
    /**
     * @param BooleanSchemaNode $booleanSchemaNode
     * @return mixed
     */
    public function visitBooleanSchemaNode(BooleanSchemaNode $booleanSchemaNode): mixed;

    /**
     * @param DefinitionNode $definitionNode
     * @return mixed
     */
    public function visitDefinitionNode(DefinitionNode $definitionNode): mixed;

    /**
     * @param DefinitionsNode $definitionsNode
     * @return mixed
     */
    public function visitDefinitionsNode(DefinitionsNode $definitionsNode): mixed;

    /**
     * @param DependenciesNode $dependenciesNode
     * @return mixed
     */
    public function visitDependenciesNode(DependenciesNode $dependenciesNode): mixed;

    /**
     * @param DependencyNode $dependencyNode
     * @return mixed
     */
    public function visitDependencyNode(DependencyNode $dependencyNode): mixed;

    /**
     * @param EmptySchemaNode $emptySchemaNode
     * @return mixed
     */
    public function visitEmptySchemaNode(EmptySchemaNode $emptySchemaNode): mixed;

    /**
     * @param EnumNode $enumNode
     * @return mixed
     */
    public function visitEnumNode(EnumNode $enumNode): mixed;

    /**
     * @param ItemsNode $itemsNode
     * @return mixed
     */
    public function visitItemsNode(ItemsNode $itemsNode): mixed;

    /**
     * @param ObjectSchemaNode $objectSchemaNode
     * @return mixed
     */
    public function visitObjectSchemaNode(ObjectSchemaNode $objectSchemaNode): mixed;

    /**
     * @param PatternPropertiesNode $patternPropertiesNode
     * @return mixed
     */
    public function visitPatternPropertiesNode(PatternPropertiesNode $patternPropertiesNode): mixed;

    /**
     * @param PatternPropertyNode $patternPropertyNode
     * @return mixed
     */
    public function visitPatternPropertyNode(PatternPropertyNode $patternPropertyNode): mixed;

    /**
     * @param PropertiesNode $propertiesNode
     * @return mixed
     */
    public function visitPropertiesNode(PropertiesNode $propertiesNode): mixed;

    /**
     * @param PropertyNode $propertyNode
     * @return mixed
     */
    public function visitPropertyNode(PropertyNode $propertyNode): mixed;

    /**
     * @param ReferenceNode $referenceNode
     * @return mixed
     */
    public function visitReferenceNode(ReferenceNode $referenceNode): mixed;

    /**
     * @param RequiredNode $requiredNode
     * @return mixed
     */
    public function visitRequiredNode(RequiredNode $requiredNode): mixed;

    /**
     * @param SequenceOfSchemaNodesNode $sequenceOfSchemaNodesNode
     * @return mixed
     */
    public function visitSequenceOfSchemaNodes(SequenceOfSchemaNodesNode $sequenceOfSchemaNodesNode): mixed;

    /**
     * @param SimpleTypeNode $simpleTypeNode
     * @return mixed
     */
    public function visitSimpleTypeNode(SimpleTypeNode $simpleTypeNode): mixed;

    /**
     * @param SimpleTypesSequenceNode $simpleTypesSequenceNode
     * @return mixed
     */
    public function visitSimpleTypesSequenceNode(SimpleTypesSequenceNode $simpleTypesSequenceNode): mixed;

    /**
     * @param UriNode $uriNode
     * @return mixed
     */
    public function visitUriNode(UriNode $uriNode): mixed;
}
