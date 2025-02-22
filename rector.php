<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector;

/**
 * 1. switch to proper PHP version no composer.json
 * 2. than use in console by: vendor/bin/rector process --clear-cache
 */
return RectorConfig::configure()
	->withPaths([
		__DIR__ . '/src',
	])
	->withRules([
		ExplicitNullableParamTypeRector::class,
	]);
