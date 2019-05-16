<?php

namespace DifferenceCalculator\Parser;

use Symfony\Component\Yaml\Yaml;

function parseData($data, $dataType)
{
    if ($dataType === 'json') {
        return json_decode($data);
    } elseif ($dataType === 'yml') {
        return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
