<?php

namespace App\Nova;

use App\Enums\UserRole;
use App\Models\Notification;
use App\Nova\Filters\UserBlocked;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Hidden;
// use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use NovaAttachMany\AttachMany;
use Carbon\Carbon;
// use Eminiarts\Tabs\Tabs;
// use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email'
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
            new Panel(__('Main Details'), [
                ID::make()->sortable(),

                Text::make('Name', 'name')
                    ->sortable()
                    ->rules('required', 'max:255'),

                Text::make('Email')
                    ->sortable()
                    ->rules('required', 'email', 'max:254')
                    ->creationRules('unique:users,email')
                    ->updateRules('unique:users,email,{{resourceId}}'),

                Password::make('Password')
                    ->onlyOnForms()
                    ->creationRules('required', 'string', 'min:8')
                    ->updateRules('nullable', 'string', 'min:8'),

                Image::make('Avatar', 'avatar')
                    // ->disk('public')
                     ->disk('s3')
                     ->path('images/user'),

                Hidden::make('Role', 'role')
                    ->default(UserRole::USER),

                Hidden::make('Email verified at', 'email_verified_at')
                    ->default(function ($request) {
                        return now();
                    }),

                Boolean::make('Is Blocked')->hideWhenUpdating(),

                Date::make('Date Of Birth', 'date_of_birth', function () {
                    return optional($this->userProfile)->date_of_birth;
                })
                    ->rules('required')
                    ->required()
                    ->sortable()
                    ->rules('after:' . Carbon::now()
                        ->subYears(99)
                        ->toDateString(), 'before:' . Carbon::now()
                        ->subYears(10)
                        ->toDateString())
                    ->format('YYYY-MM-DD')
                    ->onlyOnForms(),

                Select::make('Gender', 'gender', function () {
                    return optional($this->userProfile)->gender;
                })
                    ->options(\App\Enums\UserGender::GET_GENDER())
                    ->displayUsingLabels()
                    ->required()
                    ->rules('required')
                    ->onlyOnForms(),

                Select::make('Marital Status', 'marital_status', function () {
                    return optional($this->userProfile)->marital_status;
                })
                    ->rules('required')
                    ->options(\App\Enums\UserMaritalStatus::GET_MARITAL_STATUSES())
                    ->displayUsingLabels()
                    ->required()
                    ->onlyOnForms(),

                Number::make('Max Reminders Per Day', 'max_reminders_per_day', function () {
                    return optional($this->userProfile)->max_reminders_per_day;
                })
                    ->rules('numeric', 'required')
                    ->onlyOnForms(),

                Number::make('Min Reminders Per Day', 'min_reminders_per_day', function () {
                    return optional($this->userProfile)->min_reminders_per_day;
                })
                    ->rules('numeric', 'required')
                    ->onlyOnForms(),

                Number::make('Phone', 'phone', function () {
                    return optional($this->userProfile)->phone;
                })
                    ->rules('required', 'numeric', 'gt:0', 'nullable')
                    ->onlyOnForms()
                    ->hideWhenUpdating()
                    ->help('e.g : 973XXXXXXXX'),

                DateTime::make('Start Date', 'start_time', function () {
                    return optional($this->userProfile)->start_time;
                })
                    ->rules('required')
                    ->onlyOnForms(),

                DateTime::make('End Time', 'end_time', function () {
                    return optional($this->userProfile)->end_time;
                })
                    ->rules('required')
                    ->onlyOnForms(),

                // Select::make('Country', 'country', function () {
                //     return optional($this->userProfile)->country;
                // })->onlyOnForms(),


                // BelongsTo::make('Country', 'country', Country::class)->onlyOnForms(),



                // BelongsTo::make('IncomeLevel', 'incomeLevel', IncomeLevel::class)->onlyOnForms(),



                // BelongsTo::make('Educational Level', 'educationLevel', EducationalLevel::class)->onlyOnForms(),



                // BelongsTo::make('Intention', 'intention', Intention::class)->onlyOnForms(),



                HasOne::make('User Profile', 'userProfile', UserProfile::class)->onlyOnForms(),
            ]),
            Tabs::make(__('User Details'), [

                'Background' => [
                    HasMany::make('', 'backgrounds', Background::class),
                ],

                'Hobbies' => [
                    HasMany::make('', 'hobbies', Hobby::class),
                ],

                Tab::make('Interest', [

                    // 'Interest' => [
                    BelongsToMany::make('Interest', 'interests', Interest::class),
                    // BelongsToMany::make('', 'interests', Interest::class)->onlyOnDetail(),
                    AttachMany::make('Interest', 'interests', Interest::class)->height('150px'),

                    // ],
                ]),
            ])->withToolbar(),
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
            new UserBlocked
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

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('role', UserRole::USER);
    }
}
