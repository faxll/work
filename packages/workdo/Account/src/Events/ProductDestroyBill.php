<?php

namespace Workdo\Account\Events;

use Illuminate\Queue\SerializesModels;

class ProductDestroyBill
{
    use SerializesModels;

    public $bill;
    public $request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($bill, $request)
    {
        $this->bill = $bill;
        $this->request = $request;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
