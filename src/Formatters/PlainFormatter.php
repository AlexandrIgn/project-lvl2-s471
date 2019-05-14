<?php

namespace DifferenceCalculator\Formatters\PlainFormatter;

function getPlainFormat($ast, $partProperty = "")
{
    $result = array_reduce($ast, function ($acc, $node) use ($partProperty) {
        if ($node['type'] === 'changed') {
            $acc[] = "Property '{$partProperty}{$node['key']}' was changed. " .
                "From '{$node['beforeValue']}' to '{$node['afterValue']}'";
        } elseif ($node['type'] === 'removed') {
            $acc[] = "Property '{$partProperty}{$node['key']}' was removed";
        } elseif ($node['type'] === 'added') {
            $acc[] = "Property '{$partProperty}{$node['key']}' was added with value: " .
            (is_object($node['afterValue']) ? "'complex value'" : "'{$node['afterValue']}'");
        } elseif ($node['type'] === 'nested') {
            $acc[] = getPlainFormat($node['children'], "{$node['key']}.");
        }
         return $acc;
    }, []);
    $strResult = implode("\n", $result);
    return $strResult;
}
