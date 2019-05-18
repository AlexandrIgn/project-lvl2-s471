<?php

namespace DifferenceCalculator\Parser;

use Symfony\Component\Yaml\Yaml;

function parseData($data, $dataType)
{
    switch ($dataType) {
        case 'json':
            return json_decode($data);
        case 'yml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
