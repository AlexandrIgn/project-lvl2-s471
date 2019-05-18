<?php

namespace DifferenceCalculator\Formatters\FullFormatter;

function getFullData($ast, $depth = 0)
{
    $spaces = str_repeat('    ', $depth);
    $result = array_reduce($ast, function ($acc, $node) use ($depth, $spaces) {
        switch ($node['type']) {
            case 'unchanged':
                $acc[] = $spaces . "    {$node['key']}: " . stringify($node['beforeValue'], $depth);
                break;
            case 'changed':
                $acc[] =  $spaces . "  + {$node['key']}: " . stringify($node['afterValue'], $depth) . PHP_EOL .
                    $spaces . "  - {$node['key']}: " . stringify($node['beforeValue'], $depth);
                break;
            case 'removed':
                $acc[] = $spaces . "  - {$node['key']}: " . stringify($node['beforeValue'], $depth);
                break;
            case 'added':
                $acc[] = $spaces . "  + {$node['key']}: " . stringify($node['afterValue'], $depth);
                break;
            case 'nested':
                $acc[] = $spaces . "    {$node['key']}: " . getFullData($node['children'], $depth + 1);
                break;
        }
        return $acc;
    }, []);
    $strResult = implode("\n", $result);
    return "{\n$strResult\n{$spaces}}";
}

function stringify($nodeValue, $depth)
{
    return is_object($nodeValue) ? "{\n    " . getObjectToString($nodeValue, $depth) : replaceBoolToString($nodeValue);
}

function getObjectToString($object, $depth)
{
    $spaces = str_repeat('    ', $depth);
    $keysObject = array_keys(get_object_vars($object));
    $result = array_reduce($keysObject, function ($acc, $key) use ($object) {
        $acc[] = "{$key}: " . $object->$key;
        return $acc;
    }, []);
    $strResult = implode("\n", $result);
    return $spaces . "    {$strResult}" . "\n    {$spaces}}";
}

function replaceBoolToString($value)
{
    if (is_bool($value)) {
        return $value === true ? 'true' : 'false';
    }
    return $value;
}
