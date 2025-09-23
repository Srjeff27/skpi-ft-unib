<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PortfolioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('kategori'),
                TextEntry::make('judul_kegiatan'),
                TextEntry::make('penyelenggara'),
                TextEntry::make('tanggal_mulai')
                    ->date(),
                TextEntry::make('tanggal_selesai')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('deskripsi_kegiatan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('bukti_link'),
                TextEntry::make('status'),
                TextEntry::make('catatan_verifikator')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('verified_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
