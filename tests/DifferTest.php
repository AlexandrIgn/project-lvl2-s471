<?php

namespace DifferenceCalculator\Tests;

use function DifferenceCalculator\Differ\genDiff;
use PHPUnit\Framework\TestCase;

class DifferTest extends TestCase
{
    public function testGenDiffJson()
    {
        $pathToFirstFile = 'tests/fixtures/before.json';
        $pathToSecondFile = 'tests/fixtures/after.json';
        $expected = file_get_contents('tests/fixtures/expected');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));
    }

    public function testGenDiffYml()
    {
        $pathToFirstFile = 'tests/fixtures/before.yml';
        $pathToSecondFile = 'tests/fixtures/after.yml';
        $expected = file_get_contents('tests/fixtures/expected');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));
    }
    
    public function testGenDiffNestedJson()
    {
        $pathToFirstFile = 'tests/fixtures/beforeNested.json';
        $pathToSecondFile = 'tests/fixtures/afterNested.json';
        $expected = file_get_contents('tests/fixtures/expectedNested');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));
        
        $expected2 = file_get_contents('tests/fixtures/expectedPlain');
        $this->assertEquals($expected2, genDiff($pathToFirstFile, $pathToSecondFile, 'plain'));
    }

    public function testGenDiffNestedYml()
    {
        $pathToFirstFile = 'tests/fixtures/beforeNested.yml';
        $pathToSecondFile = 'tests/fixtures/afterNested.yml';
        $expected = file_get_contents('tests/fixtures/expectedNested');
        $this->assertEquals($expected, genDiff($pathToFirstFile, $pathToSecondFile));

        $expected2 = file_get_contents('tests/fixtures/expectedPlain');
        $this->assertEquals($expected2, genDiff($pathToFirstFile, $pathToSecondFile, 'plain'));
    }
}
