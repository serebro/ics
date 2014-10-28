<?php

namespace Ics;

abstract class Relationship extends Util
{

    /**
     * RFC 5545 cal-address
     * @var string $value
     */
    protected $value;

    /**
     * RFC 5545 cnparam
     * @var string $name
     */
    protected $name;

    /**
     * RFC 5545 dirparam
     * @var string $directory
     */
    protected $directory;

    /**
     * RFC 5545 languageparam
     * @var string $language
     */
    protected $language;

    /**
     * RFC 5545 sentbyparam
     * @var string $sentBy
     */
    protected $sentBy;


    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * RFC 5545 cal-address http://tools.ietf.org/html/rfc5545#section-3.3.3
     * @param string $uri
     * @return Relationship
     */
    public function setValue($uri)
    {
        $this->value = $this->formatUri($uri);
        return $this;
    }

    /**
     * @param string $name
     * @return Relationship
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * RFC 5545 dirparam http://tools.ietf.org/html/rfc5545#section-3.2.6
     * @param string $directory uri directory entry associated with the calendar user
     * @return Relationship
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * RFC 5545 sentbyparam http://tools.ietf.org/html/rfc5545#section-3.2.18
     * @param string $sentBy email address
     * @return Relationship
     */
    public function setSentBy($sentBy)
    {
        $this->sentBy = $sentBy;
        return $this;
    }

    /**
     * @param string $language RFC 1766 language identifier
     * @return Relationship
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    public function __toString()
    {
        return $this->toString();
    }

    abstract public function toString();
}
