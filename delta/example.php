<?php

require_once __DIR__ . '/Delta.php';

$delta = new Delta;

$original = [
    'Hello world',
    'Hrllo warlb'
];

$values = [];
foreach ($original as $index => $text) {
    $values[$index] = [];
    for ($i = 0; $i < strlen($text); $i++) {
        $values[$index][] = ord(substr($text, $i, 1));
    }
}

$deltas = [
    $delta->encode($values[0]),
    $delta->encode($values[1])
];

echo 'Delta #1: ' . implode(' ', $deltas[0]) . PHP_EOL;
echo 'Delta #2: ' . implode(' ', $deltas[1]) . PHP_EOL;

$diff = $delta->diff($deltas[0], $deltas[1]);

echo 'Length of diff: ' . count($diff) . PHP_EOL;
echo 'Diff: ' . implode(' ', $diff) . PHP_EOL;