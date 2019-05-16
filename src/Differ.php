<?php

namespace DifferenceCalculator\Differ;

use function DifferenceCalculator\Parser\parseData;
use function Funct\Collection\union;
use function DifferenceCalculator\AstBuilder\buildAst;
use function DifferenceCalculator\Formatters\FullFormatter\getFullData;
use function DifferenceCalculator\Formatters\PlainFormatter\getPlainData;
use function DifferenceCalculator\Formatters\JsonFormatter\getJsonData;

function genDiff($firstPathToFile, $secondPathToFile, $format = 'full')
{
    $dataFirstFile = file_get_contents($firstPathToFile);
    $dataSecondFile = file_get_contents($secondPathToFile);
    $firstDataType = pathinfo($firstPathToFile, PATHINFO_EXTENSION);
    $secondDataType = pathinfo($secondPathToFile, PATHINFO_EXTENSION);
    $firstParsedData = parseData($dataFirstFile, $firstDataType);
    $secondParsedData = parseData($dataSecondFile, $secondDataType);
    $ast = buildAst($firstParsedData, $secondParsedData);
    if ($format === 'plain') {
        return getPlainData($ast);
    } elseif ($format === 'json') {
        return getJsonData($ast);
    }
    return getFullData($ast);
}
