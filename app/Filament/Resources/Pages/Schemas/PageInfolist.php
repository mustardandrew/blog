<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page Details')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Title')
                            ->size('lg')
                            ->weight('bold'),

                        TextEntry::make('slug')
                            ->label('URL Slug')
                            ->copyable(),

                        TextEntry::make('author.name')
                            ->label('Author'),

                        IconEntry::make('is_published')
                            ->label('Published')
                            ->boolean()
                            ->trueIcon(Heroicon::OutlinedCheckCircle)
                            ->falseIcon(Heroicon::OutlinedXCircle)
                            ->trueColor('success')
                            ->falseColor('gray'),

                        TextEntry::make('published_at')
                            ->label('Published Date')
                            ->dateTime()
                            ->placeholder('Not published'),

                        TextEntry::make('excerpt')
                            ->label('Excerpt')
                            ->placeholder('No excerpt')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Content')
                    ->schema([
                        TextEntry::make('content')
                            ->label('Content')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),

                Section::make('SEO')
                    ->schema([
                        TextEntry::make('meta_title')
                            ->label('Meta Title')
                            ->placeholder('Uses page title'),

                        TextEntry::make('meta_description')
                            ->label('Meta Description')
                            ->placeholder('Uses excerpt or content summary')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
