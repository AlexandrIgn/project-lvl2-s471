<?php

namespace DifferenceCalculator\Formatters\PlainFormatter;

function getPlainData($ast, $partProperty = "")
{
    $result = array_reduce($ast, function ($acc, $node) use ($partProperty) {
        switch ($node['type']) {
            case 'changed':
                $acc[] = "Property '{$partProperty}{$node['key']}' was changed. " .
                    "From '{$node['beforeValue']}' to '{$node['afterValue']}'";
                break;
            case 'removed':
                $acc[] = "Property '{$partProperty}{$node['key']}' was removed";
                break;
            case 'added':
                $acc[] = "Property '{$partProperty}{$node['key']}' was added with value: " .
                (is_object($node['afterValue']) ? "'complex value'" : "'{$node['afterValue']}'");
                break;
            case 'nested':
                $acc[] = getPlainData($node['children'], "{$node['key']}.");
                break;
        }
        return $acc;
    }, []);
    $strResult = implode("\n", $result);
    return $strResult;
}
