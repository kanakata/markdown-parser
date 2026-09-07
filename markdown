<?php

use Fpdf\Fpdf;

require "../../vendor/autoload.php";
require "./utils.php";

$start = microtime(true);
function main(array $argv, int $argc)
{
    if (count($argv) == 1) {
        exit(<<<HELP
    Usage:
    php markdown[source][destination][filetype].
    HELP);
    }

    if ($argc != 4) {
        exit("
    Missing parameters.
    Usage:
    php markdown [source] [destination] [filetype].
    ");
    }

    if (!file_exists($argv[1])) {
        exit("file(" . $argv[1] . ") was not found. check the spelling or the file link and try again.");
    }

    $supported_file_types = ["html", "docx", "php", "pdf"];
    $lines = file($argv[1]);
    $filetype = $argv[3];

    if (!in_array($filetype, $supported_file_types)) {
        exit($filetype . " is currently not supported");
    }

    $filename = str_replace([".md"], "." . $filetype, pathinfo($argv[1])['basename']);
    $destination = str_ends_with($argv[2], DIRECTORY_SEPARATOR) ? $argv[2] . $filename : $argv[2] . DIRECTORY_SEPARATOR . $filename;

    if (file_exists($destination)) {
        unlink($destination);
    }

    switch ($filetype) {
        case "html":
            $replace_count = 1;
            $code = false;
            for ($i = 0; $i < count($lines); $i++) {

                if ($i == 0) {
                    file_put_contents($destination, body_start(), LOCK_EX | FILE_APPEND);
                }

                if (str_starts_with($lines[$i], "```")) {
                    if ($code == false) {
                        file_put_contents($destination, code_start(), LOCK_EX | FILE_APPEND);
                        $code = true;
                    } else {
                        file_put_contents($destination, code_end(), LOCK_EX | FILE_APPEND);
                        $code = false;
                    }
                }

                switch ($lines[$i]) {
                    case str_starts_with($lines[$i], "##"):
                        file_put_contents($destination, h2(str_replace("##", "", $lines[$i])), LOCK_EX | FILE_APPEND);
                        break;
                    case str_starts_with($lines[$i], "#"):
                        file_put_contents($destination, h1(str_replace("#", "", $lines[$i])), LOCK_EX | FILE_APPEND);
                        break;
                    case str_starts_with($lines[$i], "-"):
                        file_put_contents($destination, p(str_replace("-", "&raquo", $lines[$i], $replace_count)), LOCK_EX | FILE_APPEND);
                        break;
                    case str_starts_with($lines[$i], ">"):
                        file_put_contents($destination, note(str_replace(">", "", $lines[$i])), LOCK_EX | FILE_APPEND);
                        break;
                    case str_starts_with($lines[$i], "```php"):
                        file_put_contents($destination, str_replace(["```php"], "", $lines[$i]), LOCK_EX | FILE_APPEND);
                        break;
                    case str_starts_with($lines[$i], "```shell"):
                        file_put_contents($destination, str_replace(["```shell"], "", $lines[$i]), LOCK_EX | FILE_APPEND);
                        break;
                    case str_starts_with($lines[$i], "```ini"):
                        file_put_contents($destination, str_replace(["```ini"], "", $lines[$i]), LOCK_EX | FILE_APPEND);
                        break;
                    case str_starts_with($lines[$i], "```"):
                        file_put_contents($destination, str_replace(["```"], "", $lines[$i]), LOCK_EX | FILE_APPEND);
                        break;
                    default:
                        empty($lines[$i]) ?: file_put_contents($destination, p($lines[$i]), LOCK_EX | FILE_APPEND);
                        break;
                }

                if ($i == count($lines) - 1) {
                    file_put_contents($destination, body_end(), LOCK_EX | FILE_APPEND);
                }
            }
            file_put_contents($destination, str_replace(["\n", "\t", "\\h", ""], "",  file_get_contents($destination)), LOCK_EX);
            break;
        case "pdf":
            $pdf_convert = function () use ($lines, $destination) {
                $pdf = new Fpdf();
                $pdf->addPage();
                $pdf->setFont("Arial", 'B', 16);
                $pdf->cell(40, 10, "Hello Out There!");
                /*foreach ($lines as $line) {
                    $pdf->cell($line);
                }*/
                // file_put_contents($destination, $pdf->output());
                $file = fopen($destination, "w");
                fwrite($file, $pdf->output());
            };
            $pdf_convert();
            break;
    }

    return $destination;
}
$end = microtime(true);
exit("File generated, location(" . main($argv, $argc) . ") time taken: " . number_format(($end - $start), 4) . " seconds.");
