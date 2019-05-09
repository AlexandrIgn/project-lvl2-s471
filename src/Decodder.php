<?php

namespace DifferenceCalculator\Decodder;

use Symfony\Component\Yaml\Yaml;

function getDecodeFile($pathToFile)
{
    $dataFile = file_get_contents($pathToFile);
    if (pathinfo($pathToFile, PATHINFO_EXTENSION) === 'json') {
        return json_decode($dataFile);
    } elseif (pathinfo($pathToFile, PATHINFO_EXTENSION) === 'yml') {
        return Yaml::parse($dataFile, Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
