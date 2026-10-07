<?php
namespace Markdown\Src;
class HtmlMarkup{
    private string $css = "<style>*{box-sizing: border-box;}body{position: relative;margin: 15px;}body.dark{background: rgb(52, 52, 53);color: white;& .code {background: whitesmoke;color: black;}& .note{background: whitesmoke;color: black;padding: 10px}& .bg-mode {background: white;color: black;}}.bg-mode {border-radius: 5px;border: 1px solid black;width: 200px;position: fixed;bottom: 10px;right: 10px;height: 40px;cursor: pointer;font-size: 18px;background: black;color: white;}p {font-size: 18px;padding-left: 30px;display: flex;align-items: center;gap: 10px;}h1 {font-size: 25px;text-transform: capitalize;padding: 10px10px;border-bottom: 1px solid rgb(193, 197, 222);}h2 {font-size: 18px;text-transform: capitalize;padding: 10px10px;border-bottom: 1px solid rgb(193, 197, 222);}.note {padding: 10px;margin-bottom: 5px;font-size: 18px;border-left: 4px solid rgb(44, 120, 173);border-radius: 2px;background: whitesmoke;padding: 15px10px15px10px;}.code {background: whitesmoke;border-radius: 2px;padding: 10px;}</style>";
    public function body_start_html()
    {
        return '<head>'.$this->css.'</head><body><button class="bg-mode">change mode</button><script defer>document.querySelector(".bg-mode").addEventListener("click", () => {document.body.classList.toggle("dark");});if (window.scrollY == document.body.clientHeight) {alert()}</script>';
    }
    public function body_start_pdf()
    {
        return "<head>".$this->css."</head><body>";
    }
    public function body_end()
    {
        return "</body>";
    }
    public function mid_dot()
    {
        return "<span style='font-size:40px;'>" . "&middot" . "</span>";
    }
    public function h1(string $text)
    {
        return "<h1>".$text."</h1>";
    }
    public function h2(string $text)
    {
        return "<h2>".$text."</h2>";
    }
    public function h3(string $text)
    {
        return "<h3>".$text."</h3>";
    }
    public function h4(string $text)
    {
        return "<h4>".$text."</h4>";
    }
    public function h5(string $text)
    {
        return "<h5>".$text."</h5>";
    }
    public function h6(string $text)
    {
        return "<h6>".$text."</h6>";
    }
    public function p(string $text)
    {
        return "<p>".$text."</p>";
    }
    public function note(string $text)
    {
        return "<div class='note'>".$text."</div>";
    }
    public function code_start()
    {
        return "<div class='code'><code>";
    }
    public function code_end()
    {
        return "</code></div>";
    }
}