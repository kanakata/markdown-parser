<?php
namespace Markdown\Src;
use Markdown\Src\HtmlMarkup;
class Html{
    public function html(array $file, string $destination, string $buffer, $peddle = false){
        $markup = new HtmlMarkup();
        $replace_count = 1;
        $code = false;
        for ($i = 0; $i < count($file); $i++) {

            if ($i == 0 && $peddle == false) {
                file_put_contents($buffer, $markup->body_start_html(), LOCK_EX | FILE_APPEND);
            }else{
                file_put_contents($buffer, $markup->body_start_pdf(), LOCK_EX | FILE_APPEND);
            }

            if (str_starts_with($file[$i], "```")) {
                if ($code == false) {
                    file_put_contents($buffer, $markup->code_start(), LOCK_EX | FILE_APPEND);
                    $code = true;
                } else {
                    file_put_contents($buffer, $markup->code_end(), LOCK_EX | FILE_APPEND);
                    $code = false;
                }
            }

            switch ($file[$i]) {
                case str_starts_with($file[$i], "#"):
                    file_put_contents($buffer, $markup->h1(str_replace("#", "", $file[$i])), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "##"):
                    file_put_contents($buffer, $markup->h2(str_replace("##", "", $file[$i])), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "###"):
                    file_put_contents($buffer, $markup->h3(str_replace("##", "", $file[$i])), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "####"):
                    file_put_contents($buffer, $markup->h4(str_replace("##", "", $file[$i])), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "#####"):
                    file_put_contents($buffer, $markup->h5(str_replace("##", "", $file[$i])), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "######"):
                    file_put_contents($buffer, $markup->h6(str_replace("##", "", $file[$i])), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "-"):
                    file_put_contents($buffer, $markup->p(str_replace("-", "&raquo", $file[$i], $replace_count)), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], ">"):
                    file_put_contents($buffer, $markup->note(str_replace(">", "", $file[$i])), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "```php"):
                    file_put_contents($buffer, str_replace(["```php"], "", $file[$i]), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "```shell"):
                    file_put_contents($buffer, str_replace(["```shell"], "", $file[$i]), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "```blade"):
                    file_put_contents($buffer, str_replace(["```blade"], "", $file[$i]), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "```python"):
                    file_put_contents($buffer, str_replace(["```python"], "", $file[$i]), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "```javascript"):
                    file_put_contents($buffer, str_replace(["```javascript"], "", $file[$i]), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "```jsx"):
                    file_put_contents($buffer, str_replace(["```jsx"], "", $file[$i]), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "```ini"):
                    file_put_contents($buffer, str_replace(["```ini"], "", $file[$i]), LOCK_EX | FILE_APPEND);
                    break;
                case str_starts_with($file[$i], "```"):
                    file_put_contents($buffer, str_replace(["```"], "", $file[$i]), LOCK_EX | FILE_APPEND);
                    break;
                default:
                    empty($file[$i]) ?: file_put_contents($buffer, $markup->p($file[$i]), LOCK_EX | FILE_APPEND);
                    break;
            }

            if ($i == count($file) - 1) {
                file_put_contents($buffer, $markup->body_end(), LOCK_EX | FILE_APPEND);
            }
        }

        if(file_put_contents($buffer, str_replace(["\n", "\t", "\\h", ""], "",  file_get_contents($buffer)), LOCK_EX))
        {
            if(file_put_contents($destination, str_replace(["\n", "\t", "\\h", ""], "", file_get_contents($buffer)), LOCK_EX)){
                if (!$peddle) {
                    unlink($buffer);
                }
            }
        }
    }
}
