<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use App\Models\Platform;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $activeNavigationIcon = 'heroicon-s-newspaper';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->required()
                ->maxLength(255),

            Textarea::make('content')
                ->required()
                ->maxLength(500),

            FileUpload::make('image_url')
                ->image()
                ->directory('posts'),

            Select::make('platforms')
                ->label('Platforms')
                ->multiple()
                ->relationship('platforms', 'name')
                ->options(Platform::pluck('name', 'id'))
                ->required(),

            DateTimePicker::make('scheduled_time')
                ->label('Schedule Time')
                ->required(),

            Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'scheduled' => 'Scheduled',
                    'published' => 'Published',
                ])
                ->default('draft')
                ->required(),

            Hidden::make('user_id')
                ->default(fn() => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('title')->searchable()->sortable(),

                BadgeColumn::make('status')->label('Status'),

                TextColumn::make('scheduled_time')
                    ->label('Scheduled Time')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('platforms')
                    ->label('Platforms')
                    ->formatStateUsing(fn($record) => $record->platforms->pluck('name')->join(', '))
                    ->wrap()
                    ->limit(50)
                    ->tooltip(fn($record) => $record->platforms->pluck('name')->join(', '))
                    ->toggleable(),

                TextColumn::make('content')
                    ->toggleable()
                    ->label('Content')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(50)
                    ->wrap()
                    ->tooltip(fn($record) => $record->content),

                ImageColumn::make('image_url')
                    ->label('Image')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Scheduled',
                        'published' => 'Published',
                    ]),
            ])
            ->defaultSort('scheduled_time', 'desc');
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
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }
    public static function getModelLabel(): string
    {
        return 'Post';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Posts';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
