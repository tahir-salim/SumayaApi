<?php

namespace App\Nova\Metrics;

use App\Models\Intention;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class UserPerIntention extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $data = Intention::withCount('users')
            ->where('deleted_at', null)
            ->whereHas('users')
            ->get()
            ->toArray();

        return $this->result(array_combine(array_column($data, 'name_ar'), array_column($data, 'users_count')));
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-per-intention';
    }
}
