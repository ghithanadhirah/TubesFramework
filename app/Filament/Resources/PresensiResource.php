<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresensiResource\Pages;
use App\Filament\Resources\PresensiResource\RelationManagers;
use App\Models\Presensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Karyawan;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;


class PresensiResource extends Resource
{
    protected static ?string $model = Presensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               TextInput::make('id_presensi')
                ->label('ID Absensi')
                ->readOnly()
                ->default(fn () => Presensi::generateID())
                ->required(),


            Select::make('id_karyawan')
                ->relationship('karyawan', 'nama')
                ->required(),

            DatePicker::make('tanggal_hadir') // â pakai DatePicker di dalam form
                ->label('Tanggal Hadir')
                ->required(),

            Select::make('status')
                ->options([
                    'hadir' => 'Hadir',
                    'izin' => 'Izin',
                    'sakit' => 'Sakit',
                ])
                ->default('hadir')
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_presensi')
                    ->label('ID Absensi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('karyawan.nama')
                    ->label('Nama Pegawai')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tanggal_hadir') // â gunakan date() untuk hanya tampilkan tanggal
                    ->label('Tanggal Hadir')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->color(fn ($state) => match ($state) {
                        'hadir' => 'success',
                        'izin' => 'warning',
                        'sakit' => 'danger'
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresensis::route('/'),
            'create' => Pages\CreatePresensi::route('/create'),
            'edit' => Pages\EditPresensi::route('/{record}/edit'),
        ];
    }
}
