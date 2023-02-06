<?php

namespace App\Traits;

/**
 * using 'notify' browser event to show toasts in livewire components
 */
trait WithNotify
{
    public function notify($isError, $msg)
    {

        return $this->dispatchBrowserEvent('notify', [
            'isError' => $isError,
            'message' => $msg,
        ]);
    }
}
