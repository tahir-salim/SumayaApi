<?php

namespace App\Nova;

use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use AkkiIo\LaravelNovaSearch\LaravelNovaSearchable;


class Letter extends Resource
{
    use LaravelNovaSearchable;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Letter::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {

        return $this->name_ar . ' / ' . $this->name_en;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'day', 'name_en', 'name_ar'
    ];

    public static $searchRelations = [
        'intention' => ['name_en', 'name_ar'],
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            (new Tabs('Letter Details', [
                'Main Details' => [
                    ID::make(__('ID'), 'id')->sortable(),

                    Date::make('Day', 'day')
                        ->sortable(),

                    Text::make('English Name', 'name_en')
                        ->rules('required', 'max:255')
                        ->sortable(),

                    Text::make('Arabic Name', 'name_ar')
                        ->rules('required', 'max:255')
                        ->sortable(),
                ],
                'Intention' => [
                    BelongsTo::make('Intention', 'intention', Intention::class),

                ]
            ]))->withToolbar()->defaultSearch(false),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
