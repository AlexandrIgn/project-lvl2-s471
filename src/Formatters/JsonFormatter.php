<?php

namespace DifferenceCalculator\Formatters\JsonFormatter;

function getJsonFormat($ast)
{
    return json_encode($ast, JSON_PRETTY_PRINT);
}
