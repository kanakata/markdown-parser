<?php

namespace Markdown\Src;

use Dompdf\Dompdf;

class Pdf{
    public function pdf(array $file, string $destination, string $buffer){
        (new Html())->html($file, $destination, $buffer, true);
        $dom_pdf = new Dompdf();
        $dom_pdf->loadHtml(file_get_contents($buffer));
        $dom_pdf->setPaper("A4", "landscape");
        $dom_pdf->render();
        file_put_contents($destination, $dom_pdf->output());
        unlink($buffer);
    }
}