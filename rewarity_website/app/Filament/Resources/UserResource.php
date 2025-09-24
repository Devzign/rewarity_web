<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Admin';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Account Details')
                ->schema([
                    Forms\Components\TextInput::make('user_uid')
                        ->label('User ID')
                        ->disabled(),
                    Forms\Components\TextInput::make('employee_id')
                        ->label('Employee ID')
                        ->disabled(),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('user_type')
                        ->label('Role')
                        ->options(collect(config('user_roles.allowed', []))
                            ->mapWithKeys(fn (string $role): array => [$role => $role])
                            ->toArray())
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'Active' => 'Active',
                            'Inactive' => 'Inactive',
                        ])
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_uid')
                    ->label('User ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_type')
                    ->label('Role')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => fn (?string $state): bool => $state === 'Active',
                        'danger' => fn (?string $state): bool => $state === 'Inactive',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered On')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('User Details')
                ->schema([
                    Infolists\Components\TextEntry::make('user_uid')
                        ->label('User ID'),
                    Infolists\Components\TextEntry::make('employee_id')
                        ->label('Employee ID'),
                    Infolists\Components\TextEntry::make('name')
                        ->label('Name'),
                    Infolists\Components\TextEntry::make('email')
                        ->label('Email'),
                    Infolists\Components\TextEntry::make('user_type')
                        ->label('Role'),
                    Infolists\Components\TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->colors([
                            'success' => fn (?string $state): bool => $state === 'Active',
                            'danger' => fn (?string $state): bool => $state === 'Inactive',
                        ]),
                    Infolists\Components\TextEntry::make('created_at')
                        ->label('Registered On')
                        ->dateTime('d M Y H:i'),
                    Infolists\Components\TextEntry::make('updated_at')
                        ->label('Last Updated')
                        ->dateTime('d M Y H:i'),
                ])
                ->columns(2),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
