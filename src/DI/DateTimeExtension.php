<?php

namespace Tulinkry\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;

class DateTimeExtension extends CompilerExtension
{
    public function afterCompile(ClassType $class)
    {
        // metoda initialize
        $initialize = $class->methods['initialize'];

        $initialize->addBody(<<<EOT
    \Nette\Forms\Container::extensionMethod('addDateTime', function (\$form, \$name, \$label = null) {
        return \$form[\$name] = new \Tulinkry\Forms\Controls\DateTimeInput(\$label);
    });
EOT
        );
    }
}
