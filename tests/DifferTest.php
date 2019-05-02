<?php

namespace DifferenceCalculator\Tests;

use function DifferenceCalculator\Differ\genDiff;
use PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $pathToFirstFile = 'tests/JsonFiles/before.json';
        $pathToSecondFile = 'tests/JsonFiles/after.json';
        $expected = file_get_contents('tests/JsonFiles/expected');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));
    }
}
