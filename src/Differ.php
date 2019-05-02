<?php

namespace DifferenceCalculator\Differ;

use function Funct\Collection\union;

function genDiff($firstPathToFile, $secondPathToFile)
{
    $dataFirstFile = file_get_contents($firstPathToFile);
    $dataSecondFile = file_get_contents($secondPathToFile);
    $firstDecodeFile = json_decode($dataFirstFile, true);
    $secondDecodeFile = json_decode($dataSecondFile, true);
    $unionFirstAndSecondDecodeFiles = union($firstDecodeFile, $secondDecodeFile);
    $result = [];
    foreach ($unionFirstAndSecondDecodeFiles as $key => $value) {
        if (array_key_exists($key, $firstDecodeFile) && array_key_exists($key, $secondDecodeFile)) {
            if ($firstDecodeFile[$key] === $secondDecodeFile[$key]) {
                $result[] = "    {$key}: {$value}";
            } else {
                $result[] = "  + {$key}: {$secondDecodeFile[$key]}";
                $result[] = "  - {$key}: {$firstDecodeFile[$key]}";
            }
        } elseif (array_key_exists($key, $firstDecodeFile) && !array_key_exists($key, $secondDecodeFile)) {
            $result[] = "  - {$key}: {$firstDecodeFile[$key]}";
        } elseif (!array_key_exists($key, $firstDecodeFile) && array_key_exists($key, $secondDecodeFile)) {
            $result[] = "  + {$key}: {$secondDecodeFile[$key]}";
        }
    }
    $strResult = implode("\n", $result);
    return "{\n$strResult\n}";
}
