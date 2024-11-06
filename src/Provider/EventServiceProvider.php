<?php
namespace App\Provider;

use App\EventListener\ContentLengthListener;
use App\EventListener\InternalErrorListener;
use ChidoUkaigwe\Framework\Dbal\Event\PostPersist;
use ChidoUkaigwe\Framework\EventDispatcher\EventDispatcher;
use ChidoUkaigwe\Framework\Http\Event\ResponseEvent;
use ChidoUkaigwe\Framework\ServiceProvider\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{
    private array $listen = [
        ResponseEvent::class => [
            InternalErrorListener::class,
            ContentLengthListener::class,
        ],
        PostPersist::class => []
        ];

    public function __construct(private EventDispatcher $eventDispatcher)
    {

    }

    public function register():void
    {
        //  loop over each event in the listen array
        foreach($this->listen as $eventName => $listeners) {
            foreach(array_unique($listeners) as $listener) {
                $this->eventDispatcher->addListener($eventName, new $listener);
            }
        }
        
    }
}