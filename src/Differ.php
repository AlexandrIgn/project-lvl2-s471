<?php

namespace DifferenceCalculator\Differ;

use function Funct\Collection\union;
use Symfony\Component\Yaml\Yaml;

function genDiff($firstPathToFile, $secondPathToFile)
{
    if (getFileExtension($firstPathToFile) === 'json' && getFileExtension($secondPathToFile) === 'json') {
        $dataFirstFile = file_get_contents($firstPathToFile);
        $dataSecondFile = file_get_contents($secondPathToFile);
        $firstDecodeFile = json_decode($dataFirstFile, true);
        $secondDecodeFile = json_decode($dataSecondFile, true);
        return getParsedFile($firstDecodeFile, $secondDecodeFile);
    } elseif (getFileExtension($firstPathToFile) === 'yml' && getFileExtension($secondPathToFile) === 'yml') {
        $dataFirstFile = file_get_contents($firstPathToFile);
        $dataSecondFile = file_get_contents($secondPathToFile);
        $firstDecodeFile = Yaml::parse($dataFirstFile);
        $secondDecodeFile = Yaml::parse($dataSecondFile);
        return getParsedFile($firstDecodeFile, $secondDecodeFile);
    }
}

function getFileExtension($pathToFile)
{
    return pathinfo($pathToFile, PATHINFO_EXTENSION);
}

function getParsedFile($firstDecodeFile, $secondDecodeFile)
{
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
