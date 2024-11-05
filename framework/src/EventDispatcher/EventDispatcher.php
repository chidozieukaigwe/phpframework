<?php
namespace ChidoUkaigwe\Framework\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{

    private iterable $listeners = [];

    public function dispatch(object $event)
    {
        // Loop over the listeners for the vent 
        foreach ($this->getListenersForEvent($event) as $listener) {

            // Break if propagation is stopped

            $listener($event); // Call the listener, passing in the event (each listener will be a callable)
        }
        // Call the listener, passing in the event (each listener will be a callable)
    }

    public function getListenersForEvent(object $event): iterable
    {

    }
}