<?php 
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Penjualan;
// use App\Models\PenjualanMenu;

class TotalPenjualanChart extends ChartWidget
{
    protected static ?string $heading = 'Total Penjualan'; // Judul widget chart

    // Mendapatkan data untuk chart
    protected function getData(): array
    {
        // Ambil data total penjualan berdasarkan rumus (harga_jual - harga_beli) * jumlah
        $data = Penjualan::query()
            ->join('penjualan_menus', 'penjualans.id', '=', 'penjualan_menus.penjualan_id')
            ->join('menus', 'penjualan_menus.menu_id', '=', 'menus.id')
            ->where('penjualans.status', 'bayar') // Hanya status 'bayar'
            ->selectRaw('menus.nama, SUM(penjualan_menus.harga_jual * penjualan_menus.jml) as total_penjualan')
            ->groupBy('menus.nama')
            ->get()
            ->map(function ($penjualan) {
                return [
                    'nama' => $penjualan->nama,
                    'total_penjualan' => $penjualan->total_penjualan,
                ];
            });
            // dd($data); // untuk melihat data sebelum dikirim ke chart

        // Pastikan data ada sebelum dikirim ke chart
        if ($data->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Mengembalikan data dalam format yang dibutuhkan untuk chart
        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data->pluck('total_penjualan')->toArray(), // Data untuk chart
                    'backgroundColor' => [
                        '#36A2EB',
                        '#FF6384',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#C9CBCF',
                        '#8AC926',
                        '#1982C4',
                        '#6A4C93',
                        '#D7263D',
                        '#F49D37',
                   ],
                ],
            ],
            'labels' => $data->pluck('nama')->toArray(), // Label untuk sumbu X
        ];
    }

    // Jenis chart yang digunakan, misalnya bar chart
    protected function getType(): string
    {
        return 'pie'; // Tipe chart bisa diganti sesuai kebutuhan, seperti 'line', 'pie', dll.
    }
}