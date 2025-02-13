<?php

namespace App\Observers;

use App\Libraries\ImageConversion;
use App\Models\Background;
use Illuminate\Support\Facades\Storage;

class BackgroundObserver
{
    /**
     * Handle the Background "created" event.
     *
     * @param  \App\Models\Background  $background
     * @return void
     */
    public function creating(Background $background)
    {
        $filePath = $background->image_url;
        // dd($filePath);
        $imageThumbnail = ImageConversion::imageResize($filePath);
        $background->thumbnail_url = $imageThumbnail['path'];
    }

    /**
     * Handle the Background "updated" event.
     *
     * @param  \App\Models\Background  $background
     * @return void
     */
    public function updated(Background $background)
    {
        //
    }

    /**
     * Handle the Background "deleted" event.
     *
     * @param  \App\Models\Background  $background
     * @return void
     */
    public function deleted(Background $background)
    {
        //
    }

    /**
     * Handle the Background "restored" event.
     *
     * @param  \App\Models\Background  $background
     * @return void
     */
    public function restored(Background $background)
    {
        //
    }

    /**
     * Handle the Background "force deleted" event.
     *
     * @param  \App\Models\Background  $background
     * @return void
     */
    public function forceDeleted(Background $background)
    {
        //
    }
}
