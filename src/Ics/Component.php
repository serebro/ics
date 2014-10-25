<?php

namespace Ics;

use Exception;

class Component extends Util
{

    const CLASS_PUBLIC = 'PUBLIC';
    const CLASS_PRIVATE = 'PRIVATE';
    const CLASS_CONFIDENTIAL = 'CONFIDENTIAL';

    /** @var array */
    protected $properties = array();

    protected $xProperties = array();

    protected $component_name = '';


    public function __construct()
    {
    }

    /**
     * @throws Exception
     * @return array
     */
    public function getProperties()
    {
        if (empty($this->component_name)) {
            throw new Exception('The parameter "component_name" must not be empty');
        }

        $properties['BEGIN'] = ':' . $this->component_name;
        $properties += $this->properties;
        $properties['END'] = ':' . $this->component_name;

        return $properties;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->properties['DESCRIPTION'] = ':' . $description;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setXProperty($name, $value)
    {
        $this->xProperties[] = "$name:$value";
        return $this;
    }

    /**
     * @return array
     */
    public function getXProperties()
    {
        return $this->xProperties;
    }

    public function deleteProperty($name)
    {
        return $this->deletePropertyFrom($this->properties, $name);
    }

    public function deleteXProperty($name)
    {
        return $this->deletePropertyFrom($this->xProperties, $name);
    }

    protected function deletePropertyFrom($properties, $name)
    {
        $name = strtoupper($name);
        if (!array_key_exists($name, $properties)) {
            return false;
        }

        array_splice($properties, $name, 1);
        return true;
    }
}
