<?php

namespace App\Filament\Widgets;

use App\Models\Penjualan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class TransaksiTerakhir extends BaseWidget implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Penjualan::latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id'),
            TextColumn::make('nama_pelanggan'),
            TextColumn::make('total'),
            TextColumn::make('created_at')->dateTime(),
        ];
    
    }
}
