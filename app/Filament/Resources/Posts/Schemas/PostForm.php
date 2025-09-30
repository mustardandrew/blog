<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Grid::make()
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Content')
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                                if ($operation !== 'create') {
                                                    return;
                                                }
                                                $set('slug', Str::slug($state));
                                            }),

                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->rules(['alpha_dash']),

                                        Textarea::make('excerpt')
                                            ->maxLength(500)
                                            ->rows(3)
                                            ->columnSpanFull(),

                                        RichEditor::make('content')
                                            ->required()
                                            ->columnSpanFull()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'link',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'blockquote',
                                                'codeBlock',
                                            ]),
                                    ]),

                                Section::make('SEO')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->maxLength(60)
                                            ->helperText('Optimal length: 50-60 characters'),

                                        Textarea::make('meta_description')
                                            ->maxLength(160)
                                            ->rows(3)
                                            ->helperText('Optimal length: 120-160 characters'),

                                        TagsInput::make('meta_keywords')
                                            ->helperText('Add relevant keywords for this post'),
                                    ])
                                    ->collapsible(),
                            ]),

                        Grid::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Publishing')
                                    ->schema([
                                        Select::make('status')
                                            ->required()
                                            ->options([
                                                'draft' => 'Draft',
                                                'published' => 'Published',
                                                'archived' => 'Archived',
                                            ])
                                            ->default('draft')
                                            ->live(),

                                        DateTimePicker::make('published_at')
                                            ->visible(fn (callable $get) => $get('status') === 'published')
                                            ->default(now())
                                            ->required(fn (callable $get) => $get('status') === 'published'),

                                        Select::make('user_id')
                                            ->relationship('user', 'name')
                                            ->required()
                                            ->default(auth()->id())
                                            ->searchable(),
                                    ]),

                                Section::make('Featured Image')
                                    ->schema([
                                        FileUpload::make('featured_image')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ])
                                            ->directory('posts/featured-images')
                                            ->visibility('private'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
