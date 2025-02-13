<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Enums\ProductVariationTypeEnum;
use App\Models\VariationType;
use App\Models\VariationTypeOption;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;


class ProductVariationTypes extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected static ?string $title = 'Variation Types';

    protected static ?string $navigationIcon = 'heroicon-m-numbered-list';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Repeater::make('variationTypes')
            ->label(false)
            ->relationship()
            ->collapsible()
            ->defaultItems(1)
            ->addActionLabel('Add new variation type')
            ->columns(2)
            ->columnSpan(2)
            ->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(ProductVariationTypeEnum::labels())
                    ->required()
                    ->nullable(),
                Repeater::make('options')
                    ->relationship('options')
                    ->collapsible()
                    ->schema([
                        TextInput::make('name')
                            ->columnSpan(2)
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->openable()
                            ->panelLayout('grid')
                            ->collection('images')
                            ->reorderable('sort')
                            ->appendFiles()
                            ->preserveFilenames()
                            ->columnSpan(3),
                    ])
                    ->columnSpan(2)

            ])


        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
