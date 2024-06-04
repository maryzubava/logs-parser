<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__.'/',
    ])
    ->exclude([
        'vendor',
        'var',
    ])
    ->ignoreDotFiles(false)
    ->ignoreVCS(true)
;

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules([
        '@PhpCsFixer' => true,
        '@PSR12' => true,
        '@Symfony' => true,
        'php_unit_test_class_requires_covers' => false,
        'single_line_empty_body' => true,
        'multiline_whitespace_before_semicolons' => false,
    ])
    ->setCacheFile('/tmp/.php-cs-fixer.cache')
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
