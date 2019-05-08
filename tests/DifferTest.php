<?php

namespace DifferenceCalculator\Tests;

use function DifferenceCalculator\Differ\genDiff;
use PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    public function testGenDiffJson()
    {
        $pathToFirstFile = 'tests/JsonFiles/before.json';
        $pathToSecondFile = 'tests/JsonFiles/after.json';
        $expected = file_get_contents('tests/JsonFiles/expected');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));
    }

    public function testGenDiffYml()
    {
        $pathToFirstFile = 'tests/YamlFiles/before.yml';
        $pathToSecondFile = 'tests/YamlFiles/after.yml';
        $expected = file_get_contents('tests/YamlFiles/expected');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));
    }
    
    public function testGenDiffNestedJson()
    {
        $pathToFirstFile = 'tests/NestedJsonFiles/before.json';
        $pathToSecondFile = 'tests/NestedJsonFiles/after.json';
        $expected = file_get_contents('tests/NestedJsonFiles/expected');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));
    }

    public function testGenDiffNestedYml()
    {
        $pathToFirstFile = 'tests/NestedYamlFiles/before.yml';
        $pathToSecondFile = 'tests/NestedYamlFiles/after.yml';
        $expected = file_get_contents('tests/NestedYamlFiles/expected');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));
    }
}
