<?php declare(strict_types=1);
/*
 * (c) Sqills Products B.V. 2020 <php-dev-enschede@sqills.com>
 */
namespace Jojo1981\JsonSchemaAsg\Asg;

use Jojo1981\JsonSchemaAsg\Visitor\VisitableInterface;
use Jojo1981\JsonSchemaAsg\Visitor\VisitorInterface;

/**
 * @package Jojo1981\JsonSchemaAsg\Asg
 */
class DependencyNode implements NodeInterface, VisitableInterface
{
    /** @var DependenciesNode */
    private $parent;

    /** @var string */
    private $name;

    /** @var null|SchemaNode */
    private $schema;

    /** @var null|string[] */
    private $sequenceOfString;

    /**
     * @param DependenciesNode $parent
     * @param string $name
     */
    public function __construct(DependenciesNode $parent, string $name)
    {
        $this->parent = $parent;
        $this->name = $name;
    }

    /**
     * @return DependenciesNode
     */
    public function getParent(): DependenciesNode
    {
        return $this->parent;
    }

    /**
     * @param DependenciesNode $parent
     * @return void
     */
    public function setParent(DependenciesNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return SchemaNode|null
     */
    public function getSchema(): ?SchemaNode
    {
        return $this->schema;
    }

    /**
     * @param SchemaNode|null $schema
     * @return void
     */
    public function setSchema(?SchemaNode $schema): void
    {
        $this->schema = $schema;
    }

    /**
     * @return null|string[]
     */
    public function getSequenceOfString(): ?array
    {
        return $this->sequenceOfString;
    }

    /**
     * @param null|string[] $sequenceOfString
     * @return void
     */
    public function setSequenceOfString(?array $sequenceOfString): void
    {
        $this->sequenceOfString = $sequenceOfString;
    }

    /**
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        return $visitor->visitDependencyNode($this);
    }

}