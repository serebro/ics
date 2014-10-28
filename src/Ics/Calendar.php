<?php

namespace Ics;

class Calendar
{

    const DEFAULT_PROD_ID = '-//ICS//Calendar//EN';

    protected $version = '2.0';

    protected $prodId = '';

    protected $calendarScale = 'GREGORIAN';

    protected $method = 'PUBLISH';

    /** @var Component[] */
    protected $components = array();

    /** @var Stream */
    protected $stream;

    protected $fileExt = '.ext';


    public function __construct()
    {
        $this->stream = new Stream();
        $this->prodId = self::DEFAULT_PROD_ID;
    }

    public function addComponent(Component $component)
    {
        $this->components[] = $component;
        return $this;
    }

    /**
     * @return Component[]
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @param Component[] $components
     * @return $this
     */
    public function setComponents($components)
    {
        $this->components = $components;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getProdId()
    {
        return $this->prodId;
    }

    /**
     * @param $production_name
     * @param $lang
     * @return $this
     */
    public function setProdId($production_name, $lang)
    {
        $this->prodId = '-//' . $production_name . '//' . strtoupper($lang);
        return $this;
    }

    /**
     * @return string
     */
    public function getCalendarScale()
    {
        return $this->calendarScale;
    }

    /**
     * @param string $calendarScale
     * @return $this
     */
    public function setCalendarScale($calendarScale)
    {
        $this->calendarScale = $calendarScale;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return Stream
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @param Stream $stream
     */
    public function setStream(Stream $stream)
    {
        $this->stream = $stream;
    }

    /**
     * @return string;
     */
    public function toString()
    {
        $st = $this->stream;
        $st->reset();
        $st->add('BEGIN:VCALENDAR')
            ->add('VERSION:' . $this->getVersion())
            ->add('PRODID:' . $this->getProdId())
            ->add('CALSCALE:' . $this->getCalendarScale())
            ->add('METHOD:' . $this->getMethod());

        foreach ($this->getComponents() as $component) {
            foreach ($component->getProperties() as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $st->add($k . $v);
                    }
                } else {
                    $st->add($key . $value);
                }
            }
            foreach ($component->getXProperties() as $item) {
                $st->add($item);
            }
        }

        $st->add('END:VCALENDAR');

        return $st->get();
    }

    public function toFile($filename)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (empty($ext)) {
            $filename .= $this->fileExt;
        }

        header('Content-type: text/calendar; charset=utf-8');
        header("Content-Disposition: inline; filename=$filename");
        echo $this->toString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
