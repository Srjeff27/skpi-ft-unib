<?php

namespace App\Filament\Resources\Portfolios\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PortfoliosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')->numeric()->sortable(),
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kategori')
                    ->searchable(),
                TextColumn::make('judul_kegiatan')
                    ->searchable(),
                TextColumn::make('penyelenggara')
                    ->searchable(),
                TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable(),
                TextColumn::make('tanggal_selesai')
                    ->date()
                    ->sortable(),
                TextColumn::make('bukti_link')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'verified' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => 'Menunggu',
                    })
                    ->color(fn ($state) => match ($state) {
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'warning',
                    })
                    ->searchable(),
                TextColumn::make('verified_by')->numeric()->sortable(),
                TextColumn::make('verifikator.name')
                    ->label('Diverifikasi Oleh')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('approve')
                    ->label('Setujui')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record): bool => in_array(Auth::user()?->role, ['admin','verifikator'], true) && $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->status = 'verified';
                        $record->verified_by = Auth::id();
                        $record->verified_at = now();
                        $record->save();
                    }),
                Action::make('reject')
                    ->label('Tolak')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn ($record): bool => in_array(Auth::user()?->role, ['admin','verifikator'], true) && $record->status === 'pending')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('catatan_verifikator')
                            ->label('Alasan penolakan')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->status = 'rejected';
                        $record->catatan_verifikator = $data['catatan_verifikator'] ?? null;
                        $record->verified_by = Auth::id();
                        $record->verified_at = now();
                        $record->save();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}


