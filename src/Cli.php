<?php

namespace DifferenceCalculator\Cli;

use Docopt;
use function DifferenceCalculator\Differ\genDiff;

const REFERENCE = <<<DOC
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  --format <fmt>               bin
DOC;


function run()
{
    $args = Docopt::handle(REFERENCE);
    $firstPathToFile = $args->args['<firstFile>'];
    $secondPathToFile = $args->args['<secondFile>'];
    $format = $args->args['--format'];
    echo genDiff($firstPathToFile, $secondPathToFile, $format);
}
