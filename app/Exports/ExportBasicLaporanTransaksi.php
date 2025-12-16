<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportBasicLaporanTransaksi implements FromCollection,  WithHeadings, WithCustomStartCell, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

     protected $transaksi;
    protected $jenisTransaksi;
    protected $tanggalAwal;
    protected $tanggalAkhir;

     public function __construct($transaksi, $jenisTransaksi, $tanggalAwal, $tanggalAkhir)
    {
        $this->transaksi = $transaksi;
        $this->jenisTransaksi = $jenisTransaksi;
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }
    
      public function collection()
    {
        $result = collect();
        $data = $this->transaksi;
        foreach ($data as $index => $item) {
            $result->push([
                'NO' => $index + 1,
                'Tanggal Transaksi' => Carbon::parse($item->created_at)->format('l,d F Y'),
                'nomor_transaksi' => $item->nomor_transaksi,
                $this->jenisTransaksi == 'pemasukan' ? 'pengirim' : 'penerima' => $this->jenisTransaksi == 'pemasukan' ? $item->pengirim : $item->penerima,
                'kontak' => $item->kontak,
                'petugas' => $item->petugas,
                'Jumlah Barang' => $item->jumlah_barang,
                'total_harga' => number_format($item->total_harga),
                'Keterangan' => $item->keterangan,
            ]);
        }
        return $result;
    }

    public function headings(): array
    {
        return [
            'NO',
            'Tanggal Transaksi',
            'Nomor Transaksi',
            $this->jenisTransaksi == 'pemasukan' ? 'pengirim' : 'penerima',
            'Kontak',
            'Petugas',
            'Jumlah Barang',
            'Total Harga',
            'Keterangan',
        ];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->setCellValue('A1', 'LAPORAN TRANSAKSI ' . strtoupper($this->jenisTransaksi));
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                $periode = '-';
                if ($this->tanggalAwal && $this->tanggalAkhir) {
                    $periode = date('d M Y', strtotime($this->tanggalAwal)) . ' s/d' . date('d M Y', strtotime($this->tanggalAkhir));
                }
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->setCellValue('A2', 'Periode ' . $periode);
                $event->sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                $lastRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A4:I' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle('/PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN');

                // font size
                $event->sheet->getStyle('A4:I' . $lastRow)->getFont()->setSize(12);

                // font heaing
                $event->sheet->getStyle('A4:I4')->getFont()->setBold(true);
                $event->sheet->getStyle('A4:I4')->getAlignment()->setHorizontal('center');
            }
        ];
    }
}

