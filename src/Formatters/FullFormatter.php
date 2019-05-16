<?php

namespace DifferenceCalculator\Formatters\FullFormatter;

function getFullData($ast, $depth = 0)
{
    $spaces = str_repeat('    ', $depth);
    $result = array_reduce($ast, function ($acc, $node) use ($depth, $spaces) {
        switch ($node['type']) {
            case 'unchanged':
                $acc[] = $spaces . "    {$node['key']}: {$node['beforeValue']}";
                break;
            case 'changed':
                $acc[] = $spaces . "  + {$node['key']}: {$node['afterValue']}" . PHP_EOL .  $spaces .
                    "  - {$node['key']}: {$node['beforeValue']}";
                break;
            case 'removed':
                $acc[] = is_object($node['beforeValue']) ?
                    $spaces . "  - {$node['key']}: {\n    " . getObjectToString($node['beforeValue'], $depth) :
                    $spaces . "  - {$node['key']}: {$node['beforeValue']}";
                break;
            case 'added':
                $acc[] = is_object($node['afterValue']) ?
                    $spaces . "  + {$node['key']}: {\n    " . getObjectToString($node['afterValue'], $depth) :
                    $spaces . "  + {$node['key']}: {$node['afterValue']}";
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

function getObjectToString($object, $depth)
{
    $spaces = str_repeat('    ', $depth);
    $dataObject = get_object_vars($object);
    $keysObject = array_keys($dataObject);
    $result = array_reduce($keysObject, function ($acc, $key) use ($dataObject) {
        $acc[] = "{$key}: {$dataObject[$key]}";
        return $acc;
    }, []);
    $strResult = implode("\n", $result);
    return $spaces . "    {$strResult}" . "\n    {$spaces}}";
}
