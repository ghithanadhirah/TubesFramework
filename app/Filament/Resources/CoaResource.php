<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput; //kita menggunakan textinput
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\CoaResource\Pages;
use App\Filament\Resources\CoaResource\RelationManagers;
use App\Models\Coa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoaResource extends Resource
{
    protected static ?string $model = Coa::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Masterdata';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->schema([
                    TextInput::make('header_akun')
                        ->label('Header Akun')
                        ->required()
                        ->placeholder('Masukkan header akun'),

                    TextInput::make('kode_akun')
                        ->label('Kode Akun')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->placeholder('Masukkan kode akun'),

                    TextInput::make('nama_akun')
                        ->label('Nama Akun')
                        ->required()
                        ->placeholder('Masukkan nama akun'),

                    Select::make('jenis_akun')
                        ->label('Jenis Akun')
                        ->required()
                        ->options([
                            'Aset' => 'Aset',
                            'Kewajiban' => 'Kewajiban',
                            'Modal' => 'Modal',
                            'Pendapatan' => 'Pendapatan',
                            'Beban' => 'Beban',
                        ])
                        ->default('Aset')
                        ->placeholder('Pilih jenis akun'),

                    Select::make('posisi_normal')
                        ->label('Posisi Normal')
                        ->required()
                        ->options([
                            'Debit' => 'Debit',
                            'Kredit' => 'Kredit',
                        ])
                        ->placeholder('Pilih posisi normal'),

                    TextInput::make('saldo_nominal')
                        ->label('Saldo Nominal')
                        ->numeric()
                        ->required()
                        ->placeholder('0')
                        ->rules(['min:0']),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('header_akun')
                    ->label('Header Akun')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kode_akun')
                    ->label('Kode Akun')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nama_akun')
                    ->label('Nama Akun')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('jenis_akun')
                    ->label('Jenis Akun')
                    ->sortable(),

                TextColumn::make('posisi_normal')
                    ->label('Posisi Normal')
                    ->sortable(),

                TextColumn::make('saldo_nominal')
                    ->label('Saldo Nominal')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 2, ',', '.'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('jenis_akun')->options([
                    'Aset' => 'Aset',
                    'Kewajiban' => 'Kewajiban',
                    'Modal' => 'Modal',
                    'Pendapatan' => 'Pendapatan',
                    'Beban' => 'Beban',
                ]),
                SelectFilter::make('posisi_normal')->options([
                    'Debit' => 'Debit',
                    'Kredit' => 'Kredit',
                ]),
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
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoas::route('/'),
            'create' => Pages\CreateCoa::route('/create'),
            'edit' => Pages\EditCoa::route('/{record}/edit'),
        ];
    }
}