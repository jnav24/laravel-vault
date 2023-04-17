<?php

namespace App\Filament\Resources;

use App\Enums\RoleEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Role;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\{Card, TextInput};

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('email')->email()->required(),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create')
                        ->rules([
                            Password::min(8)
                                ->letters()
                                ->numbers()
                                ->mixedCase()
                                ->symbols()
                                ->uncompromised(3),
                        ]),
                ]),
                // @note this makes it so a user can have more than one roles. what do you want to do?
                // Card::make()->schema([
                //    Select::make('roles')
                //        ->multiple()
                //        ->relationship('roles', 'name')
                //        ->preload()
                // ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('roles.name')
                    ->label('Role')
                    ->colors([
                        'primary' => static fn ($state): bool => $state === RoleEnum::USER->value,
                        'success' => static fn ($state): bool => $state === RoleEnum::ADMIN->value,
                        'warning' => static fn ($state): bool => $state === RoleEnum::SUPER_ADMIN->value,
                    ])->sortable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Active')
                    ->options([
                        'heroicon-o-check-circle',
                        'heroicon-o-x-circle' => fn ($state, User $user): bool => $user->email_verified_at == null
                    ])
                    ->colors([
                        'success',
                        'danger' => fn ($state, User $user): bool => $user->email_verified_at == null,
                    ]),
                Tables\Columns\IconColumn::make('deleted_at')
                    ->label('Deleted')
                    ->options(['heroicon-o-x-circle' => fn ($state, User $user): bool => $user->deleted_at != null])
                    ->colors([
                        'danger' => fn ($state, User $user): bool => $user->deleted_at != null,
                    ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
//            RelationManagers\RolesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
