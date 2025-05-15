<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

use App\Filament\Resources\KaryawanResource\Pages;
use App\Filament\Resources\KaryawanResource\RelationManagers;
use App\Models\Karyawan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Grid;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Masterdata';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama')
                    ->required(),

                Radio::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->required(),
                
                TextInput::make('telepon')
                    ->label('Nomor Telepon')
                    ->required()
                    ->maxLength(15)
                    ->tel() // Ini akan mengatur input sebagai nomor telepon
                    ->placeholder('Masukkan nomor telepon')
                    ->regex('/^[0-9]+$/', 'Nomor telepon hanya boleh berisi angka.'),

                Textarea::make('alamat')
                    ->label('Alamat')
                    ->maxLength(500)
                    ->required(),

             ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            TextColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->sortable(),

            TextColumn::make('email')
                ->label('Email')
                ->sortable(),

            TextColumn::make('telepon')
                ->label('Nomor Telepon')
                ->sortable(),
            
            TextColumn::make('alamat')
                ->label('Alamat')
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
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}