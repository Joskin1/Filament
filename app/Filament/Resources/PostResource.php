<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Category;
use App\Models\Post;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use App\Filament\Exports\ProductExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Create New Post')->tabs([
                    Tab::make('Title')
                        ->icon('heroicon-o-circle-stack')
                        ->iconPosition(IconPosition::After)
                        ->badge('Hi')
                        ->schema([
                            TextInput::make('title')
                                ->live()
                                ->required()
                                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                    if ($operation === 'edit') {
                                        return;
                                    }
                                    $set('slug', Str::slug($state));
                                }),
                            TextInput::make('slug')
                                ->required()
                                ->unique()
                                ->visible(fn ($record) => $record === null),

                            Select::make('category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->preload()
                                ->searchable(),

                                Section::make('Author')->schema([
                                    Select::make('user_id')
                                    ->relationship('author', 'name')
                                    ->preload()
                                ])


                        ]),
                    Tab::make('Content')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            MarkdownEditor::make('body')->required()->columnSpanFull(),
                        ]),
                    Tab::make('Meta')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')->disk('public')->directory('thumbnail'),
                            DateTimePicker::make('publish_at'),
                        ]),

                ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                ->label('Category')
                ->searchable(),
                TextColumn::make('publish_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Publish At'),

            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
