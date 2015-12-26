<?php

use ThirdEngine\PropelSOABundle\Utility\DocBlockUtility;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

DocBlockUtility::allowAnnotations($loader);
return $loader;
