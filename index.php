<?php
require_once 'vendor/autoload.php';

use League\CLImate\CLImate;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


$defaultOutputDir = __DIR__ . '/../output.txt';
$defaultOutputDir = './output.txt';
$loggerFile = __DIR__ . '/../logs/prod/app.log';
$loggerFile = './logs/prod/app.log';

$climate = new CLImate;

// Get the input File
$inputFilePrompt = $climate->blue()
    ->input('Input File:');

$inputFile = $inputFilePrompt->prompt();

// Set the output file.
$outputFilePrompt = $climate->blue()
    ->input("Output File (default: {$defaultOutputDir}):");
$outputFilePrompt->defaultTo($defaultOutputDir);

$outputFile = $outputFilePrompt->prompt();

// Build out the logger and the main class;
$logger = new Logger('main');
$logger->pushHandler(new StreamHandler($loggerFile));
$main = new \Main($logger);

// Display the input.
$data = [
    [
        'Input File',
        $inputFile
    ],
    [
        'Output File',
        $outputFile
    ]
];

$climate->cyan()
    ->table($data);

// Update the user on the progress so they don't
// think it locked up.
$progress = $climate->progress()
    ->total(filesize($inputFile));

// Run the logger.
$result = $main->run(
    $inputFile,
    $outputFile,
    function($i) use ($progress) {
        $progress->current($i);
    }
);

// Output if error.
if (!$result) {
    $climate->red()
        ->out("Error in running application. Check {$loggerFile} for errors.");
}

// Job done.
$climate->green()
    ->out("Job Done. Check {$outputFile} for results.");
