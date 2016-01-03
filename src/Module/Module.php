<?php

namespace App\Console\Module;

use \Fine\Event;
use Symfony\Component\Console\Application;

class Module
{

    const BOOTSTRAP_PRIORITY = 500;

    protected $_app;

    public function register($app)
    {
        $this->_app = $app;
        $app->event->on('application.bootstrap', array($this, 'bootstrap'), self::BOOTSTRAP_PRIORITY);
    }

    public function bootstrap(Event $event)
    {
        if (php_sapi_name() !== 'cli') {
            return;
        }

        $event->stopPropagation();

        $this->application->run();
    }

    protected function _application()
    {
        $this->applicaiton = new Application('fine', '1.0');

        $this->_app->mod->each()->console->application($this->application);

        return $this->_application;
    }

}
