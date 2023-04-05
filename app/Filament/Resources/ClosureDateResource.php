<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ClosureDate;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClosureDateResource\Pages;
use App\Filament\Resources\ClosureDateResource\RelationManagers;

class ClosureDateResource extends Resource
{
    protected static ?string $model = ClosureDate::class;

    protected static ?string $navigationIcon = 'heroicon-s-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('academic_year')
                            ->numeric()
                            ->minValue(2022)
                            ->maxValue(2122)
                            ->required()
                            ->unique(ignoreRecord: true),
                DatePicker::make('post_end_date')->displayFormat('d-M-Y')->withoutSeconds(),
                            // ->minDate(now()->subYears(1))->displayFormat('d-M-Y')
                            // ->maxDate(now()->addYears(100))->displayFormat('d-M-Y'),
                DatePicker::make('comment_end_date')->displayFormat('d-M-Y')->withoutSeconds(),
                            // ->minDate(now()->subYears(1))->displayFormat('d-M-Y')
                            // ->maxDate(now()->addYears(100))->displayFormat('d-M-Y'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('academic_year')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('post_end_date')->date()->searchable(),
                Tables\Columns\TextColumn::make('comment_end_date')->date()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ,
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                ->visible(fn (ClosureDate $record): bool => auth()->user()->can('delete', $record)),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClosureDates::route('/'),
        ];
    }    
}
