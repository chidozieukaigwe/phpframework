<?php
namespace ChidoUkaigwe\Framework\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements EventDispatcherInterface
{

    private iterable $listeners = [];

    public function dispatch(object $event)
    {
        // Loop over the listeners for the vent 
        foreach ($this->getListenersForEvent($event) as $listener) {

            // Break if propagation is stopped
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                return $event;
            }

            $listener($event); // Call the listener, passing in the event (each listener will be a callable)
        }
        return $event; // Return the event after it has been dispatched
        // Call the listener, passing in the event (each listener will be a callable)
    }


    public function addListener(string $eventName, callable $listener): self
    {
        $this->listeners[$eventName][] = $listener;

        return $this;
    }

    public function getListenersForEvent(object $event): iterable
    {
        $eventName = get_class($event);

        if(array_key_exists($eventName, $this->listeners)) {
            return $this->listeners[$eventName];
        }

        return [];
    }
}