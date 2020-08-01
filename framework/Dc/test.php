<?php

namespace Dc\Core;


use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;
use MyAnnotation;
use ReflectionClass;


require_once dirname(__DIR__)."/../vendor/autoload.php";
require_once "./MyAnnotation.php";


$reflectionClass = new ReflectionClass(MyAnnotation::class);

$property = $reflectionClass->getProperty('bar');

$reader = new AnnotationReader();

$myAnnotation = $reader->getPropertyAnnotation($property,MyAnnotation::class);

echo $myAnnotation->myProperty;

