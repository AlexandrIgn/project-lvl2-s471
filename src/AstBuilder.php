<?php

namespace DifferenceCalculator\AstBuilder;

use function Funct\Collection\union;

function buildNode($type, $key, $beforeValue, $afterValue, $children = [])
{
    return ['type' => $type,
            'key' => $key,
            'beforeValue' => $beforeValue,
            'afterValue' => $afterValue,
            'children' => $children
    ];
}

function buildAst($firstParsedData, $secondParsedData)
{
    $firstArrayData = get_object_vars($firstParsedData);
    $secondArrayData = get_object_vars($secondParsedData);
    $unionKeys = union(array_keys($firstArrayData), array_keys($secondArrayData));
    return array_reduce($unionKeys, function ($acc, $key) use ($firstArrayData, $secondArrayData) {
        if (array_key_exists($key, $firstArrayData) && !array_key_exists($key, $secondArrayData)) {
            $acc[] = buildNode('removed', $key, $firstArrayData[$key], null);
        } elseif (!array_key_exists($key, $firstArrayData) && array_key_exists($key, $secondArrayData)) {
            $acc[] = buildNode('added', $key, null, $secondArrayData[$key]);
        } elseif (array_key_exists($key, $firstArrayData) && array_key_exists($key, $secondArrayData)) {
            if (is_object($firstArrayData[$key]) && is_object($secondArrayData[$key])) {
                $acc[] = buildNode(
                    'nested',
                    $key,
                    null,
                    null,
                    buildAst($firstArrayData[$key], $secondArrayData[$key])
                );
            } else {
                if ($firstArrayData[$key] === $secondArrayData[$key]) {
                    $acc[] = buildNode('unchanged', $key, $firstArrayData[$key], null);
                } else {
                    $acc[] = buildNode(
                        'changed',
                        $key,
                        $firstArrayData[$key],
                        $secondArrayData[$key]
                    );
                }
            }
        }
        return $acc;
    }, []);
}
