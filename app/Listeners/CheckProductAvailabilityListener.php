<?php

namespace App\Listeners;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckProductAvailabilitylistener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->productObject->quantity === 0 && $event->productObject->isAvailable()) {
            $event->productObject->status = Product::UNAVAILABLE_PRODUCT;
            $event->productObject->save();
        }
    }
}
