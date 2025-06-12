<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Pages\Page;

use Phpml\Clustering\KMeans;
use App\Models\Penjualan;
use App\Models\Pembeli;

class ClusteringVisual extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.resources.admin-resource.pages.clustering-visual';

    protected static ?string $slug = 'clustering-visual';

    public function getViewData(): array
    {
        // Data statis untuk clustering
        $samples = [
             ['name' => 'Point 1', 'x' => 1, 'y' => 2],
             ['name' => 'Point 2', 'x' => 2, 'y' => 1],
             ['name' => 'Point 3', 'x' => 1, 'y' => 1],
             ['name' => 'Point 4', 'x' => 8, 'y' => 9],
             ['name' => 'Point 5', 'x' => 9, 'y' => 8],
             ['name' => 'Point 6', 'x' => 8, 'y' => 8],
             ['name' => 'Point 7', 'x' => 5, 'y' => 5],
             ['name' => 'Point 8', 'x' => 6, 'y' => 5],
             ['name' => 'Point 9', 'x' => 5, 'y' => 6]
        ];

        // Data dinamis untuk clustering
        $samples = Pembeli::join('penjualans', 'penjualans.pembeli_id', '=', 'pembelis.id')
            ->join('penjualan_menus', 'penjualans.id', '=', 'penjualan_menus.penjualan_id')
            ->where('penjualans.status', 'bayar')
            ->select('pembelis.nama as name', \DB::raw('SUM(penjualans.tagihan) AS x'), \DB::raw('SUM(penjualan_menus.jml) AS y'))
            ->groupBy('pembelis.nama')
            ->get()->toArray();

        // Ambil koordinat untuk clustering (x dan y saja)
        $coordinates = array_map(function($sample) {
            return [$sample['x'], $sample['y']];
        }, $samples);

        // Terapkan KMeans untuk 3 cluster
        $kmeans = new KMeans(3); 
        $clusters = $kmeans->cluster($coordinates);
        // dd($clusters);
        $dataPoints = [];
        foreach ($clusters as $clusterIndex => $cluster) {
            foreach ($cluster as $point) {
                // Menemukan indeks titik pada array samples berdasarkan koordinat
                // Mencocokkan koordinat yang ada pada $cluster dengan $samples
                foreach ($samples as $pointIndex => $sample) {
                    if ($sample['x'] === $point[0] && $sample['y'] === $point[1]) {
                        $dataPoints[] = [
                            'x' => $sample['x'], // Koordinat x
                            'y' => $sample['y'], // Koordinat y
                            'name' => $sample['name'], // Nama titik
                            'cluster' => 'Cluster ' . ($clusterIndex + 1), // Nama cluster
                        ];
                        break;  // Stop setelah menemukan titik yang cocok
                    }
                }
            }
        }

        // Mengembalikan data untuk digunakan di view
        return [
            'dataPoints' => $dataPoints,
        ];

       
    }
}

