<?php

namespace Tulinkry\DI;

use Nette\DI\CompilerExtension;
use Nette\Forms\Container;
use Tulinkry\Forms\Controls\DateTimeInput;

class DateTimeExtension extends CompilerExtension
{
    public $defaults = array();

    public function loadConfiguration()
    {
        //$config = $this->getConfig($this->defaults);
        //$builder = $this->getContainerBuilder();


        $this->compiler->loadConfig($this->loadFromFile(__DIR__ . '/config.neon'))->processExtensions();
    }


    public function afterCompile()
    {
        Container::extensionMethod('addDateTime', function ($form, $name, $label = null) {
            return $form[$name] = new DateTimeInput($label);
        });
    }

}
