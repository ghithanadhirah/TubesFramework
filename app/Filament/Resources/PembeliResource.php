<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembeliResource\Pages;
use App\Models\Pembeli;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;

class PembeliResource extends Resource
{
    protected static ?string $model = Pembeli::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                
                TextInput::make('nama')
                    ->label('Nama Pembeli')
                    ->required()
                    ->placeholder('Masukkan nama pembeli'),
                
                TextInput::make('alamat')
                    ->label('alamat')
                    ->required()
                    ->placeholder('Masukkan alamat'),    

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->placeholder('Masukkan email pembeli'),
                
                    
                TextInput::make('nomor_telepon')
                    ->label('No. Telepon')
                    ->tel()
                    ->required()
                    ->placeholder('Masukkan nomor telepon'),
                
                Toggle::make('status')
                    ->label('Status Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                TextColumn::make('nama')
                    ->label('Nama Pembeli')
                    ->sortable()
                    ->searchable(),
                
            
                TextColumn::make('alamat')
                    ->label('alamat')
                    ->sortable()
                    ->searchable(),    
                
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('nomor_telepon')
                    ->label('No. Telepon')
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
            'index' => Pages\ListPembelis::route('/'),
            'create' => Pages\CreatePembeli::route('/create'),
            'edit' => Pages\EditPembeli::route('/{record}/edit'),
        ];
    }
}