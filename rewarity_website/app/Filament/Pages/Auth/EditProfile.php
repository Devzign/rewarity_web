<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public static function isSimple(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        $this->getNameFormComponent()->columnSpan(1),
                        $this->getEmailFormComponent()->columnSpan(1),
                        Forms\Components\FileUpload::make('avatar_path')
                            ->label('Profile Photo')
                            ->disk('public')
                            ->directory('avatars')
                            ->visibility('public')
                            ->image()
                            ->avatar()
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Security')
                    ->schema([
                        $this->getPasswordFormComponent()->columnSpan(1),
                        $this->getPasswordConfirmationFormComponent()->columnSpan(1),
                    ])
                    ->columns(2),
            ])
            ->operation('edit')
            ->model($this->getUser())
            ->statePath('data')
            ->inlineLabel(false);
    }
}
