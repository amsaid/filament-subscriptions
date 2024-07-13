<?php

namespace EcolePlus\FilamentSubscription\Resources;

use EcolePlus\FilamentSubscription\Actions\DownStepAction;
use EcolePlus\FilamentSubscription\Actions\UpStepAction;
use EcolePlus\FilamentSubscription\Models\Feature;
use EcolePlus\FilamentSubscription\Resources\FeatureResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Str;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static ?string $navigationIcon = "ecoleplusicon-feature";

    public static function getLabel(): ?string
    {
        return __("filament-subscriptions::ui.features");
    }

    public static function getPluralLabel(): ?string
    {
        return __("filament-subscriptions::ui.features");
    }

    public static function getNavigationLabel(): string
    {
        return __("filament-subscriptions::ui.features");
    }

    public static function getNavigationGroup(): string
    {
        return __("filament-subscriptions::ui.plans");
    }

    protected static ?string $recordTitleAttribute = "name";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->schema([
                    TextInput::make("name")
                        ->label(__("filament-subscriptions::ui.name"))
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set("slug", Str::slug($state));
                        })
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    TextInput::make("slug")
                        ->label(__("filament-subscriptions::ui.slug"))
                        ->required()
                        ->disabled()
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    TextInput::make("value")
                        ->label(__("filament-subscriptions::ui.value"))
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    TextInput::make("resettable_period")
                        ->label(
                            __("filament-subscriptions::ui.resettable_period")
                        )
                        ->numeric()
                        ->default(10)
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    Select::make("resettable_interval")
                        ->label(
                            __("filament-subscriptions::ui.resettable_interval")
                        )
                        ->options([
                            "month" => __("filament-subscriptions::ui.month"),
                            "day" => __("filament-subscriptions::ui.day"),
                            "year" => __("filament-subscriptions::ui.year"),
                        ])
                        ->default("month")
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    Select::make("status")
                        ->label(__("filament-subscriptions::ui.status"))
                        ->options([
                            "1" => __("filament-subscriptions::ui.active"),
                            "0" => __("filament-subscriptions::ui.inactive"),
                        ])
                        ->default("1")
                        ->disablePlaceholderSelection()
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    MarkdownEditor::make("description")
                        ->label(__("description"))
                        ->columnSpan([
                            "md" => 12,
                        ]),
                    FileUpload::make("image")
                        ->label(__("image"))
                        ->columnSpan([
                            "md" => 12,
                        ]),
                ])
                ->columns([
                    "md" => 12,
                ])
                ->columnSpan("full"),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("image")
                    ->label(__("filament-subscriptions::ui.image"))
                    ->circular(),
                TextColumn::make("name")
                    ->label(__("filament-subscriptions::ui.name"))
                    ->icon("heroicon-o-rectangle-stack")
                    ->sortable()
                    ->searchable(),
                TextColumn::make("plans_count")
                    ->badge()
                    ->label(__("filament-subscriptions::ui.plans_count"))
                    ->color(static function ($state): string {
                        if ($state === 0) {
                            return "danger";
                        }

                        return "success";
                    })
                    ->counts("plans"),
                TextColumn::make("resettable_period")->label(
                    __("filament-subscriptions::ui.resettable_period")
                ),
                TextColumn::make("resettable_interval")->label(
                    __("filament-subscriptions::ui.resettable_interval")
                ),
                IconColumn::make("status")
                    ->label(__("filament-subscriptions::ui.status"))
                    ->boolean()
                    ->trueIcon("heroicon-o-rectangle-stack")
                    ->falseIcon("heroicon-o-rectangle-stack"),
                TextColumn::make("created_at")->label(
                    __("filament-subscriptions::ui.created_at")
                ),
            ])
            ->filters([
                SelectFilter::make("status")
                    ->label("Status")
                    ->options([
                        "1" => __("filament-subscriptions::ui.active"),
                        "0" => __("filament-subscriptions::ui.inactive"),
                    ]),
                Filter::make("created_at")
                    ->label(__("created_at"))
                    ->form([
                        Forms\Components\DatePicker::make(
                            "created_from"
                        )->label(__("filament-subscriptions::ui.created_from")),
                        Forms\Components\DatePicker::make(
                            "created_until"
                        )->label(
                            __("filament-subscriptions::ui.created_until")
                        ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data["created_from"],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    "created_at",
                                    ">=",
                                    $date
                                )
                            )
                            ->when(
                                $data["created_until"],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    "created_at",
                                    "<=",
                                    $date
                                )
                            );
                    }),
            ])
            ->actions([
                DownStepAction::make(),
                UpStepAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->defaultSort("sort_order", "asc")
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
            "index" => Pages\ListFeatures::route("/"),
            "create" => Pages\CreateFeature::route("/create"),
            "edit" => Pages\EditFeature::route("/{record}/edit"),
        ];
    }
}
