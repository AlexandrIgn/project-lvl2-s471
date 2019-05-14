<?php

namespace DifferenceCalculator\Differ;

use function DifferenceCalculator\Parser\parseFile;
use function Funct\Collection\union;
use function DifferenceCalculator\AstBuilder\buildAst;
use function DifferenceCalculator\Formatters\DefaultFormatter\getDefaultFormat;
use function DifferenceCalculator\Formatters\PlainFormatter\getPlainFormat;
use function DifferenceCalculator\Formatters\JsonFormatter\getJsonFormat;

function genDiff($firstPathToFile, $secondPathToFile, $format = 'default')
{
    $dataFirstFile = file_get_contents($firstPathToFile);
    $dataSecondFile = file_get_contents($secondPathToFile);
    $extensionFirstFile = pathinfo($firstPathToFile, PATHINFO_EXTENSION);
    $extensionSecondFile = pathinfo($secondPathToFile, PATHINFO_EXTENSION);
    $firstParsedFile = parseFile($dataFirstFile, $extensionFirstFile);
    $secondParsedFile = parseFile($dataSecondFile, $extensionSecondFile);
    $ast = buildAst($firstParsedFile, $secondParsedFile);
    if ($format === 'default') {
        return getDefaultFormat($ast);
    } elseif ($format === 'plain') {
        return getPlainFormat($ast);
    } elseif ($format === 'json') {
        return getJsonFormat($ast);
    }
}
