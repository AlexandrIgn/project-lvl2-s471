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
    $parsedAst = getParsedFile($ast);
    if ($format === null) {
        return $parsedAst;
    }
    return getFormat($ast);
}

function getParsedFile($ast, $depth = 0)
{
    $spaces = str_repeat('    ', $depth);
    $result = [];
   // buildNode($type, $key, $beforeValue, $afterValue, $children = [])
    foreach ($ast as $node) {
        if ($node['type'] === 'unchanged') {
                $result[] = getStrNode($node, $depth);
        } elseif ($node['type'] === 'changed') {
                $result[] = getStrNode($node, $depth);
        } elseif ($node['type'] === 'removed') {
            if (is_object($node['beforeValue'])) {
                $result[] = $spaces . "  - {$node['key']}: {\n    " . getObjectToString($node['beforeValue'], $depth);
            } else {
                $result[] = getStrNode($node, $depth);
            }
        } elseif ($node['type'] === 'added') {
            if (is_object($node['afterValue'])) {
                $result[] = $spaces . "  + {$node['key']}: {\n    " . getObjectToString($node['afterValue'], $depth);
            } else {
                $result[] = getStrNode($node, $depth);
            }
        } elseif ($node['type'] === 'nested') {
            $result[] = $spaces . "    {$node['key']}: " . getParsedFile($node['children'], $depth + 1);
        }
    }
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
    $keys = array_keys($dataObject);
    $result = [];
    foreach ($dataObject as $key => $item) {
        $result[] = "{$key}: {$item}";
    }
    $strResult = implode("\n", $result);
    return $spaces . "    {$strResult}" . "\n    {$spaces}}";
}
