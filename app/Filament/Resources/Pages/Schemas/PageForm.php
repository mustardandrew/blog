<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
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
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Used in the URL. Auto-generated from title if left empty.'),

                        Textarea::make('excerpt')
                            ->maxLength(500)
                            ->helperText('Optional short description of the page.')
                            ->columnSpanFull(),

                        MarkdownEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
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
                        Select::make('author_id')
                            ->label('Author')
                            ->required()
                            ->relationship('author', 'name')
                            ->default(fn () => auth()->id())
                            ->searchable(),

                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(false)
                            ->live(),

                        DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->visible(fn ($get) => $get('is_published'))
                            ->default(now())
                            ->helperText('Leave empty to publish immediately.'),
                    ]),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Title for search engines. Leave empty to use page title.'),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->helperText('Description for search engines. Leave empty to use excerpt.')
                            ->columnSpanFull(),
                    ])->collapsible(),
            ]);
    }
}
