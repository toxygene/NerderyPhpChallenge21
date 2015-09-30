<?php
use Toxygene\JsonReader\JsonReader;

$time = microtime();

require_once 'vendor/autoload.php';

$needle = $argv[1];
$filename = $argv[2];

$reader = new JsonReader();
$reader->open($filename);

$stack = new SplStack();
$start = false;

while ($reader->read()) {
    switch (true) {
        case $reader->tokenType == JsonReader::OBJECT_END:
        case $reader->tokenType == JsonReader::ARRAY_END:
            $stack->pop();
            break;

        case $reader->tokenType == JsonReader::OBJECT_START:
            if ($reader->currentStruct == JsonReader::ARR) {
                $stack->push(
                    $stack->pop() + 1
                );
            }

            $start = true;
            break;

        case $reader->tokenType == JsonReader::ARRAY_START:
            if ($reader->currentStruct == JsonReader::ARR) {
                $stack->push(
                    $stack->pop() + 1
                );
            }

            $stack->push(-1);
            break;

        case $reader->tokenType == JsonReader::OBJECT_KEY:
            if ($start) {
                $start = false;
            } else {
                $stack->pop();
            }

            $stack->push($reader->value);
            break;

        case $reader->tokenType == JsonReader::STRING:
            if ($reader->currentStruct == JsonReader::ARR) {
                $stack->push(
                    $stack->pop() + 1
                );
            }

            if ($reader->value == $needle) {
                break 2;
            }
            break;

        case $reader->tokenType & JsonReader::VALUE:
            if ($reader->currentStruct == JsonReader::ARR) {
                $stack->push(
                    $stack->pop() + 1
                );
            }
            break;
    }
}

$reader->close();

echo implode(' -> ', array_reverse(iterator_to_array($stack))) . PHP_EOL;
