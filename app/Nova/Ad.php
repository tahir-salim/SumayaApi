<?php

namespace App\Nova;

use App\Nova\Filters\AdPublication;
use App\Nova\Filters\AdStatus;
use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaAttachMany\AttachMany;

class Ad extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Ad::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'client_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'client_name',
        'start_date',
        'end_date',
        'url'
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


            (new Tabs('Ad Details', [
                'Main Details' => [
                    ID::make(__('ID'), 'id')->sortable(),

                    Text::make('Name', 'client_name')
                        ->sortable()
                        ->rules('required', 'max:255'),

                    DateTime::make('Start Date', 'start_date')
                        ->sortable()
                        ->rules('required'),

                    DateTime::make('End Date', 'end_date')
                        ->sortable()
                        ->rules('required'),

                    Text::make('Url', 'url')
                        ->sortable()
                        ->hideFromIndex(),

                    Select::make('Status', 'status')
                        ->rules('required')
                        ->options(\App\Enums\AdStatus::GET_STATUSES())
                        ->displayUsingLabels()
                        ->required()
                        ->hideWhenCreating()
                        ->hideWhenUpdating(),

                    Image::make('Image', 'image')
                        // ->disk('public')
                        ->disk('s3')
                        ->path('images/ad'),

                    Text::make('Title', 'title')
                        ->rules('max:255')
                        ->hideFromIndex(),

                    Textarea::make('Body', 'body')
                        ->hideFromIndex(),

                    Boolean::make('Is Sumaya Publication', 'is_sumaya_publication')
                        ->hideWhenUpdating(),
                    
                        Boolean::make('Is Active', 'is_active'),
                ],
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
        return [
            new AdPublication,
            new AdStatus,
        ];
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
