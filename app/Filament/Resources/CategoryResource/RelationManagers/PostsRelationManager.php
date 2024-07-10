<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

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
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
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
                                    $set('slug', str::slug($state));
                                }),
                            TextInput::make('slug')
                                ->required()
                                ->unique(),



                            Section::make('Author')->schema([
                                Select::make('author')
                                    ->multiple()
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
                    TextInput::make('user_id')
                        ->default(auth()->id())
                        ->hidden(),
                ])->columnSpanFull(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
