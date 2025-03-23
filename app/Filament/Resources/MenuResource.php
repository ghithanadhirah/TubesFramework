<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('no_menu')
                    ->default(fn () => Menu::getNoMenu()) // Generate ID otomatis
                    ->label('No Menu')
                    ->required()
                    ->readonly(), // Tidak bisa diubah manual

                TextInput::make('nama')
                    ->required()
                    ->placeholder('Masukkan nama menu')
                    ->label('Nama Menu'),

                TextInput::make('deskripsi')
                    ->required()
                    ->placeholder('Masukkan deskripsi menu')
                    ->label('Deskripsi Menu'),

                TextInput::make('harga')
                    ->required()
                    ->minValue(0) // Tidak bisa negatif
                    ->placeholder('Masukkan harga menu')
                    ->label('Harga Menu'),

                Select::make('kategori_id')
                    ->options([
                        1 => 'Nasi',
                        2 => 'Minuman',
                        3 => 'Lauk',
                        4 => 'Sayur',
                    ])
                    ->required()
                    ->label('Kategori Menu'),

                FileUpload::make('foto')
                    ->directory('foto_menu')
                    ->required()
                    ->label('Foto Menu'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_menu')
                    ->label('No Menu')
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Menu')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kategori_id')
                    ->label('Kategori Menu')
                    ->formatStateUsing(fn ($state) => match($state) {
                        1 => 'Nasi',
                        2 => 'Minuman',
                        3 => 'Lauk',
                        4 => 'Sayur',
                        default => 'Lainnya'
                    })
                    ->sortable(),
                TextColumn::make('harga')
                    ->label('Harga Menu')
                    ->formatStateUsing(fn (string|int|null $state): string => rupiah($state))
                    ->extraAttributes(['class' => 'text-right'])
                    ->sortable(),
                ImageColumn::make('foto')
                    ->label('Foto Menu'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
