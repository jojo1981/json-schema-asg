JSON Schema ASG builder for PHP 
=====================

[![Latest Stable Version](https://poser.pugx.org/jojo1981/json-schema-asg/v/stable)](https://packagist.org/packages/jojo1981/json-schema-asg)
[![Total Downloads](https://poser.pugx.org/jojo1981/json-schema-asg/downloads)](https://packagist.org/packages/jojo1981/json-schema-asg)
[![License](https://poser.pugx.org/jojo1981/json-schema-asg/license)](https://packagist.org/packages/jojo1981/json-schema-asg)

Author: Joost Nijhuis <[jnijhuis81@gmail.com](mailto:jnijhuis81@gmail.com)>

A PHP Implementation for building an ASG (Abstract semantic graph) from a reference to a `JSON schema file`.  
Support for json schemas defined in `JSON` and `YAML`.  
Full support for the JSON schema draft 07 specification. More information can be found [here](http://json-schema.org/draft-07/schema).  
The ASG is visitable and can be visited by implementing a visitor (Behavioral Design Pattern Visitor).

Purposes of this library are:

- Validate JSON Schemas and give the end user a precise error message about semantically errors
- Transform an ASG into something else. For example generate entity classes from it, generate static validation classes, etc...
- Travers ASG by implementing your own visitor. (implement `Jojo1981\JsonSchemaAsg\Visitor\VisitorInterface`)

JSON Schema is a vocabulary that allows you to annotate and validate JSON documents. More information can be found [here](https://json-schema.org).

## Installation

### Library

```bash
git clone https://github.com/jojo1981/json-schema-asg.git
```

### Composer

[Install PHP Composer](https://getcomposer.org/doc/00-intro.md)

```bash
composer require jojo1981/json-schema-asg
```

## Implement your own visitor.

Make sure when implementing the method: `visitReferenceNode` you check if the reference is circular.
for example:

```php
    /**
     * @param ReferenceNode $referenceNode
     * @return mixed
     */
    public function visitReferenceNode(ReferenceNode $referenceNode)
    {
        if (!$referenceNode->isCircular()) {
            $referenceNode->getPointToSchema()->accept($this);
        }
    }
```


## Usage

Make sure the reference is an absolute reference to a url or file on the local file system.

```php
<?php

require 'vendor/autoload.php';

$schemaResolverFactory = new Jojo1981\JsonSchemaAsg\SchemaResolverFactory();
$schemaResolver = $schemaResolverFactory->getSchemaResolver();

// Example local files
$schemaFilenames = [
    'resources/schemas/address.schema.json',
    'resources/schemas/calendar.schema.json',
    'resources/schemas/card.schema.json',
    'resources/schemas/customer.schema.json',
    'resources/schemas/geographical-location.schema.json'
];

foreach ($schemaFilenames as $relativeSchemaFilename) {
    $absoluteSchemaFilename = \realpath($relativeSchemaFilename);
    $reference = new Jojo1981\JsonSchemaAsg\Value\Reference($absoluteSchemaFilename . '#/');
    $schema = $schemaResolver->resolveSchema($reference);
}

// Example urls
$schemaUrls = [
    'https://raw.githubusercontent.com/jojo1981/json-schema-asg/master/resources/schemas/address.schema.json',
    'https://raw.githubusercontent.com/jojo1981/json-schema-asg/master/resources/schemas/calendar.schema.json',
    'https://raw.githubusercontent.com/jojo1981/json-schema-asg/master/resources/schemas/card.schema.json',
    'https://raw.githubusercontent.com/jojo1981/json-schema-asg/master/resources/schemas/customer.schema.json',
    'https://raw.githubusercontent.com/jojo1981/json-schema-asg/master/resources/schemas/geographical-location.schema.json'
];

foreach ($schemaUrls as $schemaUrl) {
    $reference = new Jojo1981\JsonSchemaAsg\Value\Reference($schemaUrl . '#/');
    $schema = $schemaResolver->resolveSchema($reference);
}
```