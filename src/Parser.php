<?php

namespace DifferenceCalculator\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile($dataFile, $fileExtension)
{
    if ($fileExtension === 'json') {
        return json_decode($dataFile);
    } elseif ($fileExtension === 'yml') {
        return Yaml::parse($dataFile, Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
