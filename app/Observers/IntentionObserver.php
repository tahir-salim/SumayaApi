<?php

namespace App\Observers;

use App\Models\Intention;

class IntentionObserver
{
    /**
     * Handle the Intention "created" event.
     *
     * @param  \App\Models\Intention  $intention
     * @return void
     */
    public function created(Intention $intention)
    {
        Intention::removeCache();
    }

    /**
     * Handle the Intention "updated" event.
     *
     * @param  \App\Models\Intention  $intention
     * @return void
     */
    public function updated(Intention $intention)
    {
        Intention::removeCache();
    }

    /**
     * Handle the Intention "deleted" event.
     *
     * @param  \App\Models\Intention  $intention
     * @return void
     */
    public function deleted(Intention $intention)
    {
        Intention::removeCache();
    }

    /**
     * Handle the Intention "restored" event.
     *
     * @param  \App\Models\Intention  $intention
     * @return void
     */
    public function restored(Intention $intention)
    {
        Intention::removeCache();
    }

    /**
     * Handle the Intention "force deleted" event.
     *
     * @param  \App\Models\Intention  $intention
     * @return void
     */
    public function forceDeleted(Intention $intention)
    {
        //
    }
}
