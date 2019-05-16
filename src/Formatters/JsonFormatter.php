<?php

namespace DifferenceCalculator\Formatters\JsonFormatter;

function getJsonData($ast)
{
    return json_encode($ast, JSON_PRETTY_PRINT);
}
