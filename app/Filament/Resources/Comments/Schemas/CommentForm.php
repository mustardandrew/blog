<?php

namespace App\Filament\Resources\Comments\Schemas;

use App\Models\Comment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Comment Details')
                    ->schema([
                        Select::make('post_id')
                            ->label('Post')
                            ->relationship('post', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Leave empty for guest comment'),

                        TextInput::make('author_name')
                            ->label('Author Name')
                            ->placeholder('Required for guest comments')
                            ->maxLength(255)
                            ->required(fn ($get) => !$get('user_id'))
                            ->hidden(fn ($get) => $get('user_id')),

                        TextInput::make('author_email')
                            ->label('Author Email')
                            ->email()
                            ->placeholder('Required for guest comments')
                            ->maxLength(255)
                            ->required(fn ($get) => !$get('user_id'))
                            ->hidden(fn ($get) => $get('user_id')),

                        Select::make('parent_id')
                            ->label('Reply to Comment')
                            ->relationship('parent', 'content')
                            ->searchable()
                            ->preload()
                            ->placeholder('Leave empty for top-level comment')
                            ->getOptionLabelFromRecordUsing(fn (Comment $record) => 
                                'Comment by ' . $record->author_display_name . ' (' . str($record->content)->limit(50) . ')'
                            ),

                        Textarea::make('content')
                            ->label('Comment Content')
                            ->required()
                            ->rows(4)
                            ->maxLength(5000)
                            ->columnSpanFull(),

                        Toggle::make('is_approved')
                            ->label('Approved')
                            ->default(false)
                            ->helperText('Approved comments are visible on the website'),
                    ])
                    ->columns(2),
            ]);
    }
}
