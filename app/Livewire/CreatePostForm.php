<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Enums\IconPosition;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreatePostForm extends Component implements HasForms
{

    use InteractsWithForms;
    #[Layout('layouts.app')]
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Tabs::make('Create New Post')->tabs([
                    Tab::make('Title')
                        ->extraAttributes(['class' => 'p-4 text-yellow-400 bg-blue-100 rounded-lg']) // Adding background color and padding
                        ->icon('heroicon-o-circle-stack')
                        ->iconPosition(IconPosition::After)
                        ->badge('Hi')
                        ->schema([
                            TextInput::make('title')
                                ->live()
                                ->label('Post Title')
                                ->placeholder('Enter the post title here')
                                ->prefixIcon('heroicon-o-pencil')
                                ->suffixIcon('heroicon-o-check')
                                ->extraInputAttributes(['class' => 'border-2 border-blue-500 rounded-lg'])
                                ->required()
                                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                    if ($operation === 'edit') {
                                        return;
                                    }
                                    $set('slug', str::slug($state));
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
                            TextInput::make('body')->required(),

                        ]),
                    Tab::make('Meta')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')->disk('public')->directory('thumbnail'),
                            DateTimePicker::make('publish_at'),
                        ]),

                ])
                    ->extraAttributes(['class' => 'p-4 bg-yellow-400 rounded-lg'])

                    ->statePath('data')
                    // ->model(Category::class)
                    ->model(Post::class)

            ]);
    }
    public function create(): void
    {
       $post = Post::create($this->form->getState());
        Notification::make()
        ->title('Saved successfully')
        ->icon('heroicon-o-document-text')
        ->iconColor('success')
        ->success()
        ->body('Changes to the post have been saved.')
        ->actions([
            Action::make('view')
                ->button()
                ->url(route('posts.show', $post), shouldOpenInNewTab: true),
            Action::make('undo')
                ->color('gray'),
        ])
        ->duration(5000)
        ->send();
    }


    public function render()
    {
        return view('livewire.create-post-form');
    }
}
