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
 * This abstract class follows the Null object pattern and can be used to extend from so the derived class is not
 * required to implement all the visit methods declared in the VisitorInterface.
 *
 * @package Jojo1981\JsonSchemaAsg\Visitor
 */
class AbstractVisitor implements VisitorInterface
{
    /**
     * @param BooleanSchemaNode $booleanSchemaNode
     * @return mixed
     */
    public function visitBooleanSchemaNode(BooleanSchemaNode $booleanSchemaNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param DefinitionNode $definitionNode
     * @return mixed
     */
    public function visitDefinitionNode(DefinitionNode $definitionNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param DefinitionsNode $definitionsNode
     * @return mixed
     */
    public function visitDefinitionsNode(DefinitionsNode $definitionsNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param DependenciesNode $dependenciesNode
     * @return mixed
     */
    public function visitDependenciesNode(DependenciesNode $dependenciesNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param DependencyNode $dependencyNode
     * @return mixed
     */
    public function visitDependencyNode(DependencyNode $dependencyNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param EmptySchemaNode $emptySchemaNode
     * @return mixed
     */
    public function visitEmptySchemaNode(EmptySchemaNode $emptySchemaNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param EnumNode $enumNode
     * @return mixed
     */
    public function visitEnumNode(EnumNode $enumNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param ItemsNode $itemsNode
     * @return mixed
     */
    public function visitItemsNode(ItemsNode $itemsNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param ObjectSchemaNode $objectSchemaNode
     * @return mixed
     */
    public function visitObjectSchemaNode(ObjectSchemaNode $objectSchemaNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param PatternPropertiesNode $patternPropertiesNode
     * @return mixed
     */
    public function visitPatternPropertiesNode(PatternPropertiesNode $patternPropertiesNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param PatternPropertyNode $patternPropertyNode
     * @return mixed
     */
    public function visitPatternPropertyNode(PatternPropertyNode $patternPropertyNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param PropertiesNode $propertiesNode
     * @return mixed
     */
    public function visitPropertiesNode(PropertiesNode $propertiesNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param PropertyNode $propertyNode
     * @return mixed
     */
    public function visitPropertyNode(PropertyNode $propertyNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param ReferenceNode $referenceNode
     * @return mixed
     */
    public function visitReferenceNode(ReferenceNode $referenceNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param RequiredNode $requiredNode
     * @return mixed
     */
    public function visitRequiredNode(RequiredNode $requiredNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param SequenceOfSchemaNodesNode $sequenceOfSchemaNodesNode
     * @return mixed
     */
    public function visitSequenceOfSchemaNodes(SequenceOfSchemaNodesNode $sequenceOfSchemaNodesNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param SimpleTypeNode $simpleTypeNode
     * @return mixed
     */
    public function visitSimpleTypeNode(SimpleTypeNode $simpleTypeNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param SimpleTypesSequenceNode $simpleTypesSequenceNode
     * @return mixed
     */
    public function visitSimpleTypesSequenceNode(SimpleTypesSequenceNode $simpleTypesSequenceNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }

    /**
     * @param UriNode $uriNode
     * @return mixed
     */
    public function visitUriNode(UriNode $uriNode): mixed
    {
        // nothing to do here, because of the Null object pattern.
        return null;
    }
}
