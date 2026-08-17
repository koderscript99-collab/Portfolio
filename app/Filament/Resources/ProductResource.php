<?php

// This is a REFERENCE, not a drop-in file. Run:
//   php artisan make:filament-resource Product --generate
// first — it creates app/Filament/Resources/ProductResource.php for real.
// Then edit the form() method there to match this.

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\ProductFile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),

            Forms\Components\Textarea::make('description')->rows(3),

            Forms\Components\TextInput::make('price')
                ->numeric()
                ->prefix('₦')
                ->required(),

            Forms\Components\Select::make('category')
                ->options([
                    'website-template' => 'Website Template',
                    'admin-dashboard' => 'Admin Dashboard',
                    'landing-page' => 'Landing Page',
                    'component' => 'Component / Snippet',
                ]),

            Forms\Components\FileUpload::make('preview_image')
                ->image()
                ->directory('product-previews') // public disk — fine, it's just a screenshot
                ->required(),

            // The rich text instructions shown to the buyer AFTER they pay
            Forms\Components\RichEditor::make('instructions')
                ->label('Usage instructions (shown after purchase)')
                ->columnSpanFull(),

            // The private zip archive — stored on a non-public disk
            Forms\Components\FileUpload::make('zip_file')
                ->label('Product archive (.zip)')
                ->disk('local')
                ->directory('products')
                ->acceptedFileTypes([
                    'application/zip',
                    'application/x-zip-compressed',
                    'application/x-zip',
                    'application/octet-stream',
                ])
                ->required(fn (string $context) => $context === 'create')
                ->dehydrated(false) // handled manually below, not a direct column
                ->saveRelationshipsUsing(function ($record, $state) {
                    // FileUpload always stores state as an array internally,
                    // even for a single (non-multiple) file — unwrap it here.
                    $path = is_array($state) ? reset($state) : $state;

                    if ($path) {
                        ProductFile::create([
                            'product_id' => $record->id,
                            'path' => $path,
                            'version' => now()->format('Y.m.d'),
                        ]);
                    }
                }),

            Forms\Components\FileUpload::make('gallery')
                ->label('Gallery images (multiple)')
                ->image()
                ->multiple()
                ->reorderable()
                ->directory('product-galleries')
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_published')->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('price')->money('ngn'),
            Tables\Columns\IconColumn::make('is_published')->boolean(),
            Tables\Columns\TextColumn::make('orders_count')->counts('orders')->label('Sales'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}