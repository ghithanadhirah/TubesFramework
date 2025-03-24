<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriMenuResource\Pages;
use App\Filament\Resources\KategoriMenuResource\RelationManagers;
use App\Models\KategoriMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\InputMask;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload; //untuk tipe file

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

use Filament\Forms\Components\Toggle;

class KategoriMenuResource extends Resource
{
    protected static ?string $model = KategoriMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_kategori')
                    ->label('ID Kategori')
                    ->default(fn () => KategoriMenu::getIdKategori()) // Ambil default dari method generateKategoriId
                    ->required()
                    ->readonly(),
                
                TextInput::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->required()
                    ->placeholder('Masukkan nama kategori'),
                
                Toggle::make('status')
                    ->label('Status Aktif')
                    ->default(true),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_kategori')
                    ->label('ID Kategori')
                    ->sortable(),
                
                TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Nonaktif')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKategoriMenus::route('/'),
            'create' => Pages\CreateKategoriMenu::route('/create'),
            'edit' => Pages\EditKategoriMenu::route('/{record}/edit'),
        ];
    }
}
