<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GajiResource\Pages;
use App\Filament\Resources\GajiResource\RelationManagers;
use App\Models\Gaji;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;

use App\Models\Karyawan;

class GajiResource extends Resource
{
    protected static ?string $model = Gaji::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_karyawan')
                ->label('ID Karyawan')
                ->relationship('karyawan', 'nama') // atau 'kode' atau accessor
                ->searchable()
                ->required(),


            DatePicker::make('tanggal_gaji')
                ->label('Tanggal Gajian')
                ->required(),

                TextInput::make('gaji_pokok')
                ->label('Gaji Pokok')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $get, callable $set) {
                    self::hitungTotalGaji($get, $set);
                }),

            TextInput::make('bonus')
                ->label('Bonus')
                ->numeric()
                ->default(0)
                ->reactive()
                ->afterStateUpdated(function (callable $get, callable $set) {
                    self::hitungTotalGaji($get, $set);
                }),

            TextInput::make('total_gaji')
                ->label('Total Gaji')
                ->numeric()
                ->disabled() // supaya tidak bisa diedit manual
                ->dehydrated(true) // supaya nilainya tetap disimpan ke DB
                ->reactive()
                ->afterStateHydrated(function (callable $get, callable $set) {
                    self::hitungTotalGaji($get, $set);
                }),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_karyawan')
                ->label('ID Karyawan')
                ->searchable()
                ->sortable(),

            TextColumn::make('tanggal_gaji')
                ->label('Tanggal Gaji')
                ->date()
                ->sortable(),

            TextColumn::make('gaji_pokok')
                ->label('Gaji Pokok')
                ->formatStateUsing(fn ($state) => rupiah($state))
                ->sortable(),
            

            TextColumn::make('bonus')
                ->label('Bonus')
                ->formatStateUsing(fn ($state) => rupiah($state))
                ->sortable(),
            
            TextColumn::make('total_gaji')
                ->label('Total Gaji')
                ->formatStateUsing(fn ($nominal) => rupiah($nominal))
                ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

    protected static function hitungTotalGaji(callable $get, callable $set): void
    {
        $gajiPokok = floatval($get('gaji_pokok'));
        $bonus = floatval($get('bonus'));

        $set('total_gaji', $gajiPokok + $bonus);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGajis::route('/'),
            'create' => Pages\CreateGaji::route('/create'),
            'edit' => Pages\EditGaji::route('/{record}/edit'),
        ];
    }
}
