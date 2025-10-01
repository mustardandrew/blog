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
                Section::make('Post & Context')
                    ->description('Select the post and context for this comment')
                    ->schema([
                        Select::make('post_id')
                            ->label('Post')
                            ->relationship('post', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Select the post this comment belongs to'),

                        Select::make('parent_id')
                            ->label('Reply to Comment')
                            ->relationship('parent', 'content')
                            ->searchable()
                            ->preload()
                            ->placeholder('Leave empty for top-level comment')
                            ->helperText('Select a parent comment if this is a reply')
                            ->getOptionLabelFromRecordUsing(fn (Comment $record) => 
                                'Comment by ' . $record->author_display_name . ' (' . str($record->content)->limit(50) . ')'
                            ),
                    ])
                    ->columns(2),

                Section::make('Author Information')
                    ->description('Specify who wrote this comment')
                    ->schema([
                        Select::make('user_id')
                            ->label('Registered User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Leave empty for guest comment')
                            ->helperText('Select a registered user or leave empty for guest comment')
                            ->live()
                            ->columnSpanFull(),

                        TextInput::make('author_name')
                            ->label('Guest Author Name')
                            ->placeholder('Enter guest author name')
                            ->maxLength(255)
                            ->required(fn ($get) => !$get('user_id'))
                            ->visible(fn ($get) => !$get('user_id'))
                            ->helperText('Required when no registered user is selected'),

                        TextInput::make('author_email')
                            ->label('Guest Author Email')
                            ->email()
                            ->placeholder('Enter guest author email')
                            ->maxLength(255)
                            ->required(fn ($get) => !$get('user_id'))
                            ->visible(fn ($get) => !$get('user_id'))
                            ->helperText('Required when no registered user is selected'),
                    ])
                    ->columns(2),

                Section::make('Comment Content')
                    ->description('The main content and moderation status')
                    ->schema([
                        Textarea::make('content')
                            ->label('Comment Text')
                            ->required()
                            ->rows(5)
                            ->maxLength(5000)
                            ->placeholder('Enter the comment content...')
                            ->helperText('Maximum 5000 characters')
                            ->columnSpanFull(),

                        Toggle::make('is_approved')
                            ->label('Approved for Public Display')
                            ->default(false)
                            ->helperText('Only approved comments are visible on the website')
                            ->inline(false),
                    ]),
            ]);
    }
}
