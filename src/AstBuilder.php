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

function buildAst($firstDecodeFile, $secondDecodeFile)
{
    $firstArrayData = get_object_vars($firstDecodeFile);
    $secondArrayData = get_object_vars($secondDecodeFile);
    $unionKeys = union(array_keys($firstArrayData), array_keys($secondArrayData));
    return array_reduce($unionKeys, function ($acc, $key) use ($firstArrayData, $secondArrayData) {
        if (array_key_exists($key, $firstArrayData) && !array_key_exists($key, $secondArrayData)) {
            $acc[] = buildNode('removed', $key, replaceBoolToString($firstArrayData[$key]), 'without value');
        } elseif (!array_key_exists($key, $firstArrayData) && array_key_exists($key, $secondArrayData)) {
            $acc[] = buildNode('added', $key, 'without value', replaceBoolToString($secondArrayData[$key]));
        } elseif (array_key_exists($key, $firstArrayData) && array_key_exists($key, $secondArrayData)) {
            if (is_object($firstArrayData[$key]) && is_object($secondArrayData[$key])) {
                $acc[] = buildNode(
                    'nested',
                    $key,
                    'without value',
                    'without value',
                    buildAst($firstArrayData[$key], $secondArrayData[$key])
                );
            } else {
                if ($firstArrayData[$key] === $secondArrayData[$key]) {
                    $acc[] = buildNode('unchanged', $key, replaceBoolToString($firstArrayData[$key]), 'without value');
                } else {
                    $acc[] = buildNode(
                        'changed',
                        $key,
                        replaceBoolToString($firstArrayData[$key]),
                        replaceBoolToString($secondArrayData[$key])
                    );
                }
            }
        }
        return $acc;
    }, []);
}

function replaceBoolToString($value)
{
    if (is_bool($value)) {
        return $value === true ? 'true' : 'false';
    }
    return $value;
}
