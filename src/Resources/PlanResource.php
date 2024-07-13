<?php

namespace EcolePlus\FilamentSubscription\Resources;

use EcolePlus\FilamentSubscription\Models\Currency;
use EcolePlus\FilamentSubscription\Models\Feature;
use EcolePlus\FilamentSubscription\Models\Plan;
use EcolePlus\FilamentSubscription\Resources\PlanResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
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

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = "ecoleplusicon-plan";

    public static function getLabel(): ?string
    {
        return __("filament-subscriptions::ui.plans");
    }

    public static function getPluralLabel(): ?string
    {
        return __("filament-subscriptions::ui.plans");
    }

    public static function getNavigationLabel(): string
    {
        return __("filament-subscriptions::ui.plans");
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
                        //->disabled()
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    Select::make("currency_id")
                        ->label(__("filament-subscriptions::ui.currency"))
                        ->live(onBlur: true)
                        ->required()
                        ->options(
                            Currency::all()->pluck("name", "id")->toArray()
                        )
                        ->searchable()
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    TextInput::make("price")
                        ->label(__("filament-subscriptions::ui.price"))
                        ->numeric()
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    TextInput::make("signup_fee")
                        ->label(__("filament-subscriptions::ui.signup_fee"))
                        ->numeric()
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    TextInput::make("trial_period")
                        ->label(__("filament-subscriptions::ui.trial_period"))
                        ->numeric()
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    Select::make("period")
                        ->label(__("filament-subscriptions::ui.period"))
                        ->options([
                            "Yearly" => __("filament-subscriptions::ui.yearly"),
                            "Monthly" => __(
                                "filament-subscriptions::ui.monthly"
                            ),
                        ])
                        ->default("Monthly")
                        ->columnSpan([
                            "md" => 6,
                        ]),
                    TextInput::make("active_subscribers_limit")
                        ->label(
                            __(
                                "filament-subscriptions::ui.active_subscribers_limit"
                            )
                        )
                        ->numeric()
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

            Section::make()
                ->schema([
                    Forms\Components\Placeholder::make("All Features"),
                    CheckboxList::make("features")
                        ->relationship("features", "id")
                        ->label(__("filament-subscriptions::ui.all_features"))
                        ->options(Feature::pluck("name", "id")->toArray())
                        ->columns(3)
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
                TextColumn::make("price")
                    ->label(__("filament-subscriptions::ui.price"))
                    ->sortable()
                    ->searchable(),
                TextColumn::make("features_count")
                    ->badge()
                    ->label(__("filament-subscriptions::ui.features_count"))
                    ->color(static function ($state): string {
                        if ($state === 0) {
                            return "danger";
                        }

                        return "success";
                    })
                    ->counts("features"),
                TextColumn::make("subscriptions_count")
                    ->badge()
                    ->label(
                        __("filament-subscriptions::ui.subscriptions_count")
                    )
                    ->color(static function ($state): string {
                        if ($state === 0) {
                            return "danger";
                        }

                        return "success";
                    })
                    ->counts("subscriptions"),
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
                    ->label(__("filament-subscriptions::ui.status"))
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
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
            "index" => Pages\ListPlans::route("/"),
            "create" => Pages\CreatePlan::route("/create"),
            "edit" => Pages\EditPlan::route("/{record}/edit"),
        ];
    }
}
