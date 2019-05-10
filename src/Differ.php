<?php

namespace DifferenceCalculator\Differ;

use function DifferenceCalculator\Decodder\getDecodeFile;
use function Funct\Collection\union;
use function DifferenceCalculator\AstBuilder\buildAst;
use function DifferenceCalculator\Formater\getFormat;

function genDiff($firstPathToFile, $secondPathToFile, $format = null)
{
    $firstDecodeFile = getDecodeFile($firstPathToFile);
    $secondDecodeFile = getDecodeFile($secondPathToFile);
    $ast = buildAst($firstDecodeFile, $secondDecodeFile);
    if ($format === null) {
        return getParsedFile($ast);
    }
    return getFormat($ast, $format);
}

function getParsedFile($ast, $depth = 0)
{
    $spaces = str_repeat('    ', $depth);
    $result = array_reduce($ast, function ($acc, $node) use ($depth, $spaces) {
        if ($node['type'] === 'unchanged') {
            $acc[] = getStrNode($node, $depth);
        } elseif ($node['type'] === 'changed') {
            $acc[] = getStrNode($node, $depth);
        } elseif ($node['type'] === 'removed') {
            if (is_object($node['beforeValue'])) {
                $acc[] = $spaces . "  - {$node['key']}: {\n    " . getObjectToString($node['beforeValue'], $depth);
            } else {
                $acc[] = getStrNode($node, $depth);
            }
        } elseif ($node['type'] === 'added') {
            if (is_object($node['afterValue'])) {
                $acc[] = $spaces . "  + {$node['key']}: {\n    " . getObjectToString($node['afterValue'], $depth);
            } else {
                $acc[] = getStrNode($node, $depth);
            }
        } elseif ($node['type'] === 'nested') {
            $acc[] = $spaces . "    {$node['key']}: " . getParsedFile($node['children'], $depth + 1);
        }
        return $acc;
    }, []);
    $strResult = implode("\n", $result);
    return "{\n$strResult\n{$spaces}}";
}

function getStrNode($node, $depth)
{
    $spaces = str_repeat('    ', $depth);
    if ($node['type'] === 'unchanged') {
        return $spaces . "    {$node['key']}: {$node['beforeValue']}";
    } elseif ($node['type'] === 'changed') {
        $afterValue = $spaces . "  + {$node['key']}: {$node['afterValue']}";
        $beforeValue = $spaces . "  - {$node['key']}: {$node['beforeValue']}";
        return "{$afterValue}\n{$beforeValue}";
    } elseif ($node['type'] === 'removed') {
        return $spaces . "  - {$node['key']}: {$node['beforeValue']}";
    } elseif ($node['type'] === 'added') {
        return $spaces . "  + {$node['key']}: {$node['afterValue']}";
    }
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
