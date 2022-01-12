<?php

$xml   = new DOMDocument();
$xml->load(__DIR__ . '/phpunit.xml');
$xpath = new DOMXPath($xml);

foreach ($xpath->query('//php/env') as $element) {
    set_environment_variable($element->getAttribute('name'), $element->getAttribute('value'));
}

foreach ($xpath->query('//php/ini') as $element) {
    ini_set($element->getAttribute('name'), $element->getAttribute('value'));
}

function set_environment_variable(string $name, $value)
{
    // If PHP is running as an Apache module and an existing
    // Apache environment variable exists, overwrite it
    if (function_exists('apache_getenv') && function_exists('apache_setenv') && apache_getenv($name) !== false) {
        apache_setenv($name, $value);
    }

    if (function_exists('putenv')) {
        putenv("$name=$value");
    }

    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
}
