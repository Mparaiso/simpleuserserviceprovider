<?php

namespace Mparaiso\Rdv\Event;

use Symfony\Component\EventDispatcher\Event;

class DinnerBeforeCreateEvent extends Event {

    private $dinner;

    function __construct($dinner) {
        $this->dinner = $dinner;
    }

    function getDinner() {
        return $this->dinner;
    }

}