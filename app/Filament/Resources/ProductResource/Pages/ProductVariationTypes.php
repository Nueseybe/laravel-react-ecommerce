<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Enums\ProductVariationTypeEnum;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;


class ProductVariationTypes extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected static ?string $navigationIcon = 'heroicon-c-photo';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Repeater::make('variationTypes')
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
                    ->required(),
                Repeater::make('options')
                    ->relationship()
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
                            -columnSpan(3)
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
