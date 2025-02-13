<?php

namespace App\Nova;

use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use AkkiIo\LaravelNovaSearch\LaravelNovaSearchable;

class Affirmation extends Resource
{
    use LaravelNovaSearchable;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Affirmation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {

        return $this->ar_text . ' / ' . $this->en_text;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'ar_text',
        'en_text'
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
            (new Tabs('Affirmation Details', [
                'Main Details' => [
                    ID::make(__('ID'), 'id')->sortable(),

                    Text::make('Arabic Text', 'ar_text')
                        ->rules('required', 'max:255')
                        ->sortable(),

                    Text::make('English Text', 'en_text')
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
