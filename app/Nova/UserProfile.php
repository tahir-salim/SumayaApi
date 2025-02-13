<?php

namespace App\Nova;

use App\Nova\Filters\UserGender;
use App\Nova\Filters\UserMaritalStatus;
use Carbon\Carbon;
use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserProfile extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\UserProfile::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {

        return optional($this->user)->name;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'gender',
        'date_of_birth',
        'marital_status',
        'start_time',
        'end_time'
    ];

    public static $displayInNavigation = false;


    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            (new Tabs('User Profile Details', [
                'Main Details' => [
                    ID::make(__('ID'), 'id')->sortable(),

                    Date::make('Date Of Birth', 'date_of_birth')
                        ->rules('required')
                        ->sortable()
                        ->rules('after:' . Carbon::now()
                            ->subYears(99)
                            ->toDateString(), 'before:' . Carbon::now()
                            ->subYears(10)
                            ->toDateString())
                        ->format('YYYY-MM-DD')
                        ->hideFromIndex(),

                    Select::make('Gender', 'gender')
                        ->options(\App\Enums\UserGender::GET_GENDER())
                        ->displayUsingLabels(),

                    Select::make('Marital Status', 'marital_status')
                        ->rules('required')
                        ->options(\App\Enums\UserMaritalStatus::GET_MARITAL_STATUSES())
                        ->displayUsingLabels()
                        ->required(),

                    Number::make('Max Reminders Per Day', 'max_reminders_per_day')
                        ->rules('numeric', 'required')
                        ->hideFromIndex(),

                    Number::make('Min Reminders Per Day', 'min_reminders_per_day')
                        ->rules('numeric', 'required')
                        ->hideFromIndex(),

                    Number::make('Phone')
                        ->rules('numeric', 'gt:0', 'nullable')
                        ->hideFromIndex()
                        ->hideWhenUpdating()
                        ->help('e.g : 973XXXXXXXX'),

                    DateTime::make('Start Date', 'start_time')
                        ->rules('required'),

                    DateTime::make('End Time', 'end_time')
                        ->rules('required'),
                    // BelongsTo::make('User', 'user', User::class),
                ],
                'User' => [],

                'Country' => [
                    BelongsTo::make('Country', 'country', Country::class),
                ],

                'IncomeLevel' => [
                    BelongsTo::make('IncomeLevel', 'incomeLevel', IncomeLevel::class),
                ],

                'Educational Level' => [
                    BelongsTo::make('Educational Level', 'educationLevel', EducationalLevel::class),
                ],

                'Intention' => [
                    BelongsTo::make('Intention', 'intention', Intention::class),
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
            new UserGender,
            new UserMaritalStatus
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
