<?php
/**
 * Konverter Markdown ke DOCX Berstandar Microsoft Word XML
 * Margin: Kiri 4cm (2268), Atas 3cm (1701), Kanan 3cm (1701), Bawah 3cm (1701)
 */

$templatePath = __DIR__ . '/ACARA-13_A_E41250223_MUHAMMAD AFIF RAMDHANI.docx';

function xmlEscape($text) {
    return htmlspecialchars($text, ENT_XML1 | ENT_COMPAT, 'UTF-8');
}

function parseMarkdownToXml($md) {
    $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $md));
    $xml = '';
    $inCodeBlock = false;
    $isHeader = true;

    foreach ($lines as $line) {
        $trimmed = trim($line);

        // Abaikan heading dan identitas awal markdown karena sudah ada di Cover
        if ($isHeader) {
            if (str_starts_with($trimmed, '# ') || str_starts_with($trimmed, '## ') || str_starts_with($trimmed, '**Identitas') || str_starts_with($trimmed, '- **') || $trimmed === '---') {
                continue;
            }
            if ($trimmed !== '') {
                $isHeader = false;
            } else {
                continue;
            }
        }

        // Handle Code Blocks
        if (str_starts_with($trimmed, '```')) {
            $inCodeBlock = !$inCodeBlock;
            continue;
        }

        if ($inCodeBlock) {
            $esc = xmlEscape($line);
            $xml .= '<w:p><w:pPr><w:spacing w:line="240" w:lineRule="auto" w:before="0" w:after="0"/><w:shd w:val="clear" w:color="auto" w:fill="F4F4F4"/><w:rPr><w:rFonts w:ascii="Consolas" w:hAnsi="Consolas"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr></w:pPr><w:r><w:rPr><w:rFonts w:ascii="Consolas" w:hAnsi="Consolas"/><w:sz w:val="18"/><w:szCs w:val="18"/></w:rPr><w:t xml:space="preserve">' . $esc . '</w:t></w:r></w:p>';
            continue;
        }

        if ($trimmed === '') {
            continue;
        }

        if ($trimmed === '---') {
            continue;
        }

        // Heading 3: ### A. Pokok Bahasan
        if (str_starts_with($trimmed, '### ')) {
            $title = trim(substr($trimmed, 4));
            $xml .= '<w:p><w:pPr><w:spacing w:before="240" w:after="120" w:line="360" w:lineRule="auto"/><w:jc w:val="both"/><w:rPr><w:b/><w:bCs/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r><w:rPr><w:b/><w:bCs/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>' . xmlEscape($title) . '</w:t></w:r></w:p>';
            continue;
        }

        // Heading 4: #### 1. Langkah
        if (str_starts_with($trimmed, '#### ')) {
            $title = trim(substr($trimmed, 5));
            $xml .= '<w:p><w:pPr><w:spacing w:before="180" w:after="80" w:line="360" w:lineRule="auto"/><w:jc w:val="both"/><w:rPr><w:b/><w:bCs/><w:sz w:val="23"/><w:szCs w:val="23"/></w:rPr></w:pPr><w:r><w:rPr><w:b/><w:bCs/><w:sz w:val="23"/><w:szCs w:val="23"/></w:rPr><w:t>' . xmlEscape($title) . '</w:t></w:r></w:p>';
            continue;
        }

        // List item bullet (- atau *)
        $isList = false;
        if (str_starts_with($trimmed, '- ') || str_starts_with($trimmed, '* ')) {
            $isList = true;
            $trimmed = trim(substr($trimmed, 2));
        }

        // Tokenize text untuk format bold (**teks**)
        $tokens = preg_split('/(\*\*.*?\*\*)/', $trimmed, -1, PREG_SPLIT_DELIM_CAPTURE);
        $runs = '';

        if ($isList) {
            $runs .= '<w:r><w:rPr><w:rFonts w:ascii="Symbol" w:hAnsi="Symbol"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t></w:t></w:r><w:r><w:t xml:space="preserve">  </w:t></w:r>';
        }

        foreach ($tokens as $token) {
            if ($token === '') continue;
            if (str_starts_with($token, '**') && str_ends_with($token, '**') && strlen($token) >= 4) {
                $boldText = substr($token, 2, -2);
                $runs .= '<w:r><w:rPr><w:b/><w:bCs/></w:rPr><w:t xml:space="preserve">' . xmlEscape($boldText) . '</w:t></w:r>';
            } else {
                $runs .= '<w:r><w:t xml:space="preserve">' . xmlEscape($token) . '</w:t></w:r>';
            }
        }

        if ($isList) {
            $xml .= '<w:p><w:pPr><w:spacing w:line="360" w:lineRule="auto" w:after="60"/><w:jc w:val="both"/><w:ind w:left="720" w:hanging="360"/></w:pPr>' . $runs . '</w:p>';
        } else {
            $xml .= '<w:p><w:pPr><w:spacing w:line="360" w:lineRule="auto" w:after="100"/><w:jc w:val="both"/></w:pPr>' . $runs . '</w:p>';
        }
    }

    return $xml;
}

$targetAcara = array_merge([11, 12], range(15, 30));

foreach ($targetAcara as $i) {
    $mdFile = __DIR__ . "/ACARA-{$i}_A_E41250223_MUHAMMAD AFIF RAMDHANI.md";
    $docxFile = __DIR__ . "/ACARA-{$i}_A_E41250223_MUHAMMAD AFIF RAMDHANI.docx";

    if (!file_exists($mdFile)) {
        echo "File MD Acara $i tidak ditemukan\n";
        continue;
    }

    $mdContent = file_get_contents($mdFile);
    copy($templatePath, $docxFile);

    $zip = new ZipArchive();
    if ($zip->open($docxFile) === TRUE) {
        $origDocXml = $zip->getFromName('word/document.xml');

        // Cover berakhir persis sebelum elemen paragraf Prosedur Kerja
        $pos = strpos($origDocXml, 'Prosedur Kerja');
        $coverEndPos = strrpos(substr($origDocXml, 0, $pos), '<w:p ');
        $coverPart = substr($origDocXml, 0, $coverEndPos);

        // Ganti nomor Acara pada cover
        $coverPart = preg_replace('/(TUGAS PRAKTIKUM ACARA\s*<\/w:t><\/w:r><w:r[^>]*><w:rPr>.*?<\/w:rPr><w:t>)1<\/w:t><\/w:r><w:r[^>]*><w:rPr>.*?<\/w:rPr><w:t>3/s', '${1}' . $i, $coverPart);
        $coverPart = preg_replace('/(TUGAS PRAKTIKUM ACARA\s*<\/w:t><\/w:r><w:r[^>]*><w:rPr>.*?<\/w:rPr><w:t>)\d+(<\/w:t>)/s', '${1}' . $i . '${2}', $coverPart);

        // Bangun isi dokumen dari Markdown
        $bodyXml = parseMarkdownToXml($mdContent);

        // Pengaturan Margin halaman isi: Kiri 4cm (2268), Atas 3cm (1701), Kanan 3cm (1701), Bawah 3cm (1701)
        $sectPr = '<w:sectPr w:rsidR="00C46D90" w:rsidSect="002F7748"><w:headerReference w:type="default" r:id="rId8"/><w:pgSz w:w="11907" w:h="16840"/><w:pgMar w:top="1701" w:right="1701" w:bottom="1701" w:left="2268" w:header="708" w:footer="708" w:gutter="0"/><w:pgNumType w:start="1"/><w:cols w:space="720"/><w:docGrid w:linePitch="360"/></w:sectPr>';

        $finalXml = $coverPart . $bodyXml . $sectPr . '</w:body></w:document>';

        // Validasi XML dengan DOMDocument sebelum disimpan ke zip
        $dom = new DOMDocument();
        if (!$dom->loadXML($finalXml)) {
            echo "ERROR: XML tidak valid untuk Acara $i!\n";
        } else {
            $zip->addFromString('word/document.xml', $finalXml);
            echo "Sukses & Valid XML: ACARA-{$i}_A_E41250223_MUHAMMAD AFIF RAMDHANI.docx\n";
        }
        $zip->close();
    }
}
