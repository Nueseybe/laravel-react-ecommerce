<?php

namespace App\Filament\Resources;

use Filament\Resources\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Filament\Facades\Filament;
use App\Enums\ProductStatusEnum;
use App\Models\Product;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\Pages\ProductImages;
use App\Filament\Resources\ProductResource\Pages\ProductVariationTypes;
use App\Enums\RolesEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Str;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition:: End;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        TextInput::make('title')
                        ->live('blur')
                            ->required()
                            ->afterStateUpdated(
                                function(string $operation, $state, callable $set){
                                    $set("slug", Str::slug($state));
                                }
                            ),
                        TextInput::make('slug')
                            ->required(),
                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->label(__('Department'))
                            ->preload()
                            ->searchable()
                            ->required()
                            ->reactive() // makes the field reactive to changes
                            ->afterStateUpdated(function(callable $set){
                                $set('category_id', null); // reset the category when the department changes
                            }),
                        Select::make('category_id')
                            ->relationship(
                                name: 'Category',
                                titleAttribute:'name',
                                modifyQueryUsing: function ( Builder $query, callable $get){
                                    $departmentId= $get('department_id'); //get selected department
                                    if($departmentId){
                                        $query->where('department_id', $departmentId); // filter categories based on department

                                    }
                                }
                                )
                            ->label(__('Category'))
                            ->preload()
                            ->searchable()
                            ->required()
                            ]),
                    Forms\Components\RichEditor::make('description')
                            ->required()
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                                'table'
                            ])
                            ->columnSpan(2),
                    TextInput::make('price')
                        ->required()
                        ->numeric(),
                    TextInput::make('quantity')
                        ->integer(),
                    Select::make('status')
                        ->options(ProductStatusEnum::labels())
                        ->default(ProductStatusEnum::Draft->value)
                        ->required()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->limit(1)
                    ->label('Image')
                    ->conversion('thumb'),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->colors(ProductStatusEnum::colors()),
                TextColumn::make('department.name'),
                TextColumn::make('category.name'),
                TextColumn::make('created_by'),
                TextColumn::make('updated_by')
                    ->dateTime()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ProductStatusEnum::labels()),
                SelectFilter::make('department_id')
                    ->relationship('department','name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'images'=> Pages\ProductImages::route('{record}/images'),
            'variation-types'=> Pages\ProductVariationTypes::route('{record}/variation-types'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
                EditProduct::class,
                ProductImages::class,
                ProductVariationTypes::class,

            ]);

    }


    public static function canViewAny(): bool
    {
        $user = Filament::auth()->user();
        return $user && $user->hasRole(RolesEnum::Vendor);
    }
}
