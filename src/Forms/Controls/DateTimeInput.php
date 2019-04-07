<?php

namespace Tulinkry\Forms\Controls;

use Latte\Runtime\Template;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\DateTime;
use Nette\Utils\Html;
use Tulinkry;

class DateTimeInput extends TextInput
{

    /**
     * @var string
     */
    protected $format = "Y-m-d H:i:s";
    protected $databaseFormat = "Y-m-d H:i:s";
    protected $className = "datetimepicker";

    protected function getDataDateFormat()
    {
        $format = preg_replace("/d/", "DD", $this->format);
        $format = preg_replace("/m/", "MM", $format);
        $format = preg_replace("/Y/", "YYYY", $format);
        $format = preg_replace("/H/", "HH", $format);
        $format = preg_replace("/i/", "mm", $format);
        $format = preg_replace("/s/", "ss", $format);
        $format = preg_replace("/j/", "D", $format);
        $format = preg_replace("/n/", "M", $format);
        return $format;
    }

    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getValue()
    {
        return DateTime::createFromFormat($this->format, $this->rawValue);
    }

    public function getControl()
    {
        $this->setAttribute("data-date-format=\"" . $this->getDataDateFormat() . "\"");
        $this->getControlPrototype()
            ->addClass($this->className);

        $input = parent::getControl();

        // dependency on other date
        $ret = Html::el("div");
        $ret->add($input);
        $ret->add($this->getJsLoader());

        return $ret;
    }

    protected function getJsLoader()
    {
        $element = Html::el("span");
        $element->style = 'display: none';

        /** @var $template Template */
        $template = clone $this->form->parent->template;
        $template->setFile(__DIR__ . '/templates/loader.latte');
        $template->id = $this->getHtmlId();
        $element->setHtml($template->render());

        return $element;
    }
}
