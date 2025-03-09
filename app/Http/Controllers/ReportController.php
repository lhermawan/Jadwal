<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class ReportController extends Controller
{
    public function export($week)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Header
        $section->addText("PEMERINTAH KABUPATEN CIAMIS", ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addText("DINAS KOMUNIKASI DAN INFORMATIKA", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $section->addText("WEEKLY REPORT CALL TAKER 112 MINGGU #$week", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $section->addTextBreak(2);

        // Tabel Data Call Taker
        $table = $section->addTable();
        $table->addRow();
        $headers = ["Call Taker", "Normal Call", "Prank Call", "Ghost Call", "Total", "Keterangan"];
        foreach ($headers as $header) {
            $table->addCell(2000)->addText($header, ['bold' => true]);
        }

        // Data Call Taker (Contoh, bisa diambil dari database)
        $callData = [
            ["BAIQA", 5, 14, 3, 22, "Laporan Gangguan Lampu Merah Rusak di Simpang Pahlawan Ciamis (Pelapor Bpk Tino)"],
            ["ADILLA", 2, 6, 1, 9, "Bukan Kedaruratan"],
            ["SANTI", 0, 14, 2, 16, "Bukan Kedaruratan"],
            ["GAGAH", 1, 4, 6, 11, "Laporan Kabel PLN Kendur/Turun di Jl. Kapten Murod Idrus"],
            ["KHAIRUL", 0, 2, 0, 2, "Bukan Kedaruratan"],
            ["HAIDAR", 2, 8, 1, 11, "Bukan Kedaruratan"],
            ["TIM PELAPIS", 0, 1, 0, 1, "Bukan Kedaruratan"],
        ];

        foreach ($callData as $row) {
            $table->addRow();
            foreach ($row as $cell) {
                $table->addCell(2000)->addText($cell);
            }
        }

        // Aduan Darurat Tertangani
        $section->addTextBreak(2);
        $section->addText("Aduan Darurat Tertangani:", ['bold' => true, 'size' => 12]);
        $aduan = [
            "Gangguan Lampu Merah Rusak di Simpang Pahlawan Ciamis - Pelapor: a/n Bpk Tino",
            "Laporan Kabel PLN Kendur/Turun (Lokasi: Jl. Kapten Murod Idrus) - Pelapor: a/n Bpk Ali",
        ];
        foreach ($aduan as $index => $item) {
            $section->addText(($index + 1) . ". " . $item);
        }

        // Keterangan Normal Call Lainnya
        $section->addTextBreak(2);
        $section->addText("Keterangan Normal Call Lainnya:", ['bold' => true, 'size' => 12]);
        $keterangan = [
            "Telepon warga yang menanyakan cara aktifkan SIM Card Telkomsel",
            "Menanyakan cara membuka blokir hp yang terkunci oleh pola.",
        ];
        foreach ($keterangan as $index => $item) {
            $section->addText(($index + 1) . ". " . $item);
        }

        // Simpan file DOCX
        $fileName = "WEEKLY_REPORT_MINGGU_$week.docx";
        $path = storage_path('app/public/' . $fileName);
        $phpWord->save($path);

        return response()->download($path)->deleteFileAfterSend();
    }
}
