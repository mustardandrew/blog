<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                            ->rules(['alpha_dash'])
                            ->helperText('Used in the URL. Auto-generated from title if left empty.'),

                        Textarea::make('excerpt')
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('Optional short description of the post.')
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
                    ])->columns(2),

                Section::make('Publishing')
                    ->schema([
                        Select::make('user_id')
                            ->label('Author')
                            ->relationship('user', 'name')
                            ->required()
                            ->default(auth()->id())
                            ->searchable(),

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
                            ->label('Publish Date')
                            ->visible(fn (callable $get) => $get('status') === 'published')
                            ->default(now())
                            ->required(fn (callable $get) => $get('status') === 'published')
                            ->helperText('Date when the post will be published.'),

                        FileUpload::make('featured_image')
                            ->label('Featured Image')
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

                Section::make('Categories')
                    ->schema([
                        CheckboxList::make('categories')
                            ->relationship('categories', 'name')
                            ->options(function () {
                                return \App\Models\Category::active()
                                    ->orderBy('sort_order')
                                    ->pluck('name', 'id');
                            })
                            ->columns(2)
                            ->searchable()
                            ->helperText('Select categories for this post.'),
                    ]),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Title for search engines. Leave empty to use post title.'),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Description for search engines. Leave empty to use excerpt.')
                            ->columnSpanFull(),

                        TagsInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->helperText('Add relevant keywords for this post')
                            ->columnSpanFull(),
                    ])->collapsible(),
            ]);
    }
}
