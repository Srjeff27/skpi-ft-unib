<?php

namespace App\Filament\Resources\Portfolios;

use App\Filament\Resources\Portfolios\Pages\CreatePortfolio;
use App\Filament\Resources\Portfolios\Pages\EditPortfolio;
use App\Filament\Resources\Portfolios\Pages\ListPortfolios;
use App\Filament\Resources\Portfolios\Pages\ViewPortfolio;
use App\Filament\Resources\Portfolios\Tables\PortfoliosTable;
use App\Models\Portfolio;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Portfolio';
    protected static ?string $recordTitleAttribute = 'judul_kegiatan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id())
                    ->required()
                    ->visibleOn('create'),

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Pemilik Portofolio')
                    ->disabled()
                    ->visibleOn('edit')
                    ->hidden(fn (): bool => ! in_array(Auth::user()?->role, ['admin', 'verifikator'], true)),

                Forms\Components\TextInput::make('judul_kegiatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kategori')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('penyelenggara')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_selesai'),
                Forms\Components\Textarea::make('deskripsi_kegiatan')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('bukti_link')
                    ->url()
                    ->required()
                    ->maxLength(255),

                // Bidang verifikasi (hanya untuk admin/verifikator)
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending')
                    ->hidden(fn (): bool => ! in_array(Auth::user()?->role, ['admin', 'verifikator'], true)),
                Forms\Components\Textarea::make('catatan_verifikator')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->visible(fn ($get): bool => $get('status') === 'rejected')
                    ->hidden(fn (): bool => ! in_array(Auth::user()?->role, ['admin', 'verifikator'], true)),
                Forms\Components\Select::make('verified_by')
                    ->relationship('verifikator', 'name')
                    ->label('Diverifikasi Oleh')
                    ->default(Auth::id())
                    ->visible(fn ($get): bool => $get('status') === 'verified')
                    ->hidden(fn (): bool => ! in_array(Auth::user()?->role, ['admin', 'verifikator'], true)),
                Forms\Components\DateTimePicker::make('verified_at')
                    ->label('Tanggal Verifikasi')
                    ->default(now())
                    ->visible(fn ($get): bool => $get('status') === 'verified')
                    ->hidden(fn (): bool => ! in_array(Auth::user()?->role, ['admin', 'verifikator'], true)),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return PortfoliosTable::configure($table);
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
            'index' => ListPortfolios::route('/'),
            'create' => CreatePortfolio::route('/create'),
            'view' => ViewPortfolio::route('/{record}'),
            'edit' => EditPortfolio::route('/{record}/edit'),
        ];
    }
}
