<?php
namespace ChidoUkaigwe\Framework\Dbal\Event;

use ChidoUkaigwe\Framework\Dbal\Entity;
use ChidoUkaigwe\Framework\EventDispatcher\Event;

class PostPersist extends Event
{

    public function __construct(private Entity $subject)
    {

    }

}