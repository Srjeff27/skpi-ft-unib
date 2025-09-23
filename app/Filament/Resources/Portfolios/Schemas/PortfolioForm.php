<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('kategori')
                    ->required(),
                TextInput::make('judul_kegiatan')
                    ->required(),
                TextInput::make('penyelenggara')
                    ->required(),
                DatePicker::make('tanggal_mulai')
                    ->required(),
                DatePicker::make('tanggal_selesai'),
                Textarea::make('deskripsi_kegiatan')
                    ->columnSpanFull(),
                TextInput::make('bukti_link')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                Textarea::make('catatan_verifikator')
                    ->columnSpanFull(),
                TextInput::make('verified_by')
                    ->numeric(),
                DateTimePicker::make('verified_at'),
            ]);
    }
}
