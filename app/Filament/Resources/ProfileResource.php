<?php

// Reference file. Run: php artisan make:filament-resource Profile --generate
// first, then edit the real app/Filament/Resources/ProfileResource.php to
// match this — it adds the avatar upload and restricts creation to one row.

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Portfolio Info';

    // Only ever allow one profile row to exist
    public static function canCreate(): bool
    {
        return static::getModel()::count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('avatar')
                ->image()
                ->directory('profile')
                ->avatar() // circular preview, nice for a portrait photo
                ->columnSpanFull(),

            Forms\Components\TextInput::make('name')->required(),

            Forms\Components\TextInput::make('tagline')
                ->placeholder('e.g. I build websites and sell templates'),

            Forms\Components\Textarea::make('bio')
                ->rows(6)
                ->placeholder('A paragraph about your background and what you offer.')
                ->columnSpanFull(),

            Forms\Components\Repeater::make('social_links')
                ->label('Social media links')
                ->schema([
                    Forms\Components\FileUpload::make('icon')
                        ->label('Logo')
                        ->image()
                        ->directory('social-icons')
                        ->avatar(),

                    Forms\Components\TextInput::make('name')
                        ->label('Platform name')
                        ->placeholder('e.g. Instagram, X, LinkedIn')
                        ->required(),

                    Forms\Components\TextInput::make('url')
                        ->label('Profile URL')
                        ->url()
                        ->required()
                        ->placeholder('https://...'),
                ])
                ->columns(3)
                ->collapsible()
                ->reorderable()
                ->addActionLabel('Add social link')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('support_whatsapp')
                ->label('WhatsApp number')
                ->placeholder('2348012345678 — digits only, country code, no + or spaces')
                ->helperText('Used to build your WhatsApp contact link. Include country code, no +, no spaces, no leading 0 after the country code.'),

            Forms\Components\TextInput::make('support_email')
                ->label('Support email')
                ->email()
                ->placeholder('you@example.com'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('avatar')->circular(),
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('tagline'),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}