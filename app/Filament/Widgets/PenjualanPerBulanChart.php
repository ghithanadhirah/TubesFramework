<?php 
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Penjualan;
// use App\Models\PenjualanMenu;

use Carbon\Carbon;

class PenjualanPerBulanChart extends ChartWidget
{
    // protected static ?string $heading = 'Penjualan Per Bulan '+date('Y'); // Judul widget chart
    protected static ?string $heading = null; // biarkan null

    public function getHeading(): string
    {
        return 'Penjualan Per Bulan ' . date('Y');
    }

    

    // Mendapatkan data untuk chart
    protected function getData(): array
    {
        // Tahun yang ingin ditampilkan
        $year = now()->year;

        // Ambil data total penjualan berdasarkan rumus (harga_jual - harga_beli) * jumlah
        $orders = Penjualan::query()
            ->join('penjualan_menus', 'penjualans.id', '=', 'penjualan_menus.penjualan_id')
            ->join('menus', 'penjualan_menus.menu_id', '=', 'menus.id')
            ->where('penjualans.status', 'bayar') // Hanya status 'bayar'
            ->whereYear('penjualans.tgl', $year)
            ->selectRaw('MONTH(penjualans.tgl) as month, SUM(penjualan_menus.harga_jual * penjualan_menus.jml) as total_penjualan')
            ->groupBy('month')
            ->pluck('total_penjualan', 'month');
            // dd($data); // untuk melihat data sebelum dikirim ke chart

         // Siapkan semua bulan (1–12)
         $allMonths = collect(range(1, 12));

         // Gabungkan semua bulan dengan hasil orders
        $data = $allMonths->map(function ($month) use ($orders) {
            return $orders->get($month, 0);
        });

        $labels = $allMonths->map(function ($month) {
            return Carbon::create()->month($month)->locale('id')->translatedFormat('F'); // Januari, Februari, ...
        });

        // Mengembalikan data dalam format yang dibutuhkan untuk chart
        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data, // Data untuk chart
                    'backgroundColor' => '#36A2EB',
                ],
            ],
            'labels' => $labels, // Label untuk sumbu X
        ];
    }

    // Jenis chart yang digunakan, misalnya bar chart
    protected function getType(): string
    {
        return 'line'; // Tipe chart bisa diganti sesuai kebutuhan, seperti 'line', 'pie', dll.
    }
}