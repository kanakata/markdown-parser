<?php
require dirname(__DIR__) .  "/vendor/autoload.php";
use Markdown\Src\Html;
use Markdown\Src\Pdf;
$start = microtime(true);
function main(array $argv, int $argc)
{
    if (count($argv) == 1) {
        echo "  Usage: \033[32m markdown [source file] [file destination] [filetype] \033[0m \n";
        echo "  Example: \033[32m markdown c:file.md c: pdf \033[0m ";
        exit();
    }

    if ($argc != 4) {
        echo "Missing parameters.\nUsage: \033[32m markdown [source] [destination] [filetype]. \033[0m";
        exit();
    }

    if (!file_exists($argv[1])) {
        echo "\033[31m file(" . $argv[1] . ") was not found.\033[0m check the spelling or the file link and try again. \033[0m";
        exit();
    }

    $supported_file_types = ["html", "docx", "php", "pdf"];

    $file = file($argv[1]);
    $filetype = strtolower($argv[3]);

    if (!in_array($filetype, $supported_file_types)) {
        echo "\033[42m" . $filetype . " is currently not supported \033[0m";
        exit();
    }

    $filename = str_replace([".md"], "." . $filetype, pathinfo($argv[1])['basename']);
    $destination = str_ends_with($argv[2], DIRECTORY_SEPARATOR) ? $argv[2] . $filename : $argv[2] . DIRECTORY_SEPARATOR . $filename ?? "C:" . DIRECTORY_SEPARATOR;

    $buffer = __DIR__ . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "buffer" . DIRECTORY_SEPARATOR . microtime(true) . $filename;

    if (file_exists($destination)) {
        unlink($destination);
    }

    switch ($filetype) {
        case "html":
            (new Html)->html($file, $destination, $buffer);
            break;
        case "pdf":
            (new Pdf)->pdf($file, $destination, $buffer);
            break;
    }

    return $destination;
}

exit("\033[32mSuccess: \033[0m File generated, location (" . main($argv, $argc) . ") time taken: " . number_format((microtime(true) - $start), 4) . " seconds.");