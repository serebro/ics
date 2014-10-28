<?php

namespace Ics\Component;

use DateTime;
use Ics\Component;
use InvalidArgumentException;
use Ics\Relationship\Attendee;
use Ics\Relationship\Organizer;

class Event extends Component
{

    const STATUS_TENTATIVE = 'TENTATIVE';
    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_CANCELLED = 'CANCELLED';

    protected $component_name = 'VEVENT';

    /** @var  Alarm */
    protected $alarm;


    public function __construct()
    {
        parent::__construct();
        $this->properties['CLASS'] = ':' . self::CLASS_PUBLIC;
        $this->properties['UID'] = ':' . spl_object_hash($this);
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->properties['COMMENT'] = ':' . $this->escape($comment);
        return $this;
    }

    public function setCategories(array $categories)
    {
        $this->properties['CATEGORIES'] = ':' . $this->_list($categories);
        return $this;
    }

    protected function _list(array $list)
    {
        if (!count($list)) {
            throw new InvalidArgumentException();
        }
        $list = array_map('trim', $list);
        $list = array_map('strtoupper', $list);
        return join(',', $list);
    }

    public function setResources(array $resources, $lang = null)
    {
        $value = '';
        if ($lang) {
            $value = ";LANGUAGE=$lang";
        }
        $value .= ':' . $this->_list($resources);

        $this->properties['RESOURCES'] = $value;

        return $this;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setClassification($class)
    {
        if (!in_array($class, array(self::CLASS_CONFIDENTIAL, self::CLASS_PRIVATE, self::CLASS_PUBLIC))) {
            throw new InvalidArgumentException('The parameter "class" in not valid');
        }
        $this->properties['CLASS'] = ':' . $class;
        return $this;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return $this
     */
    public function addGeoPosition($latitude, $longitude)
    {
        $this->properties['GEO'] = ':' . $latitude . ';' . $longitude;
        return $this;
    }

    /**
     * @param string $uri
     * @param string $lang
     * @param string $name
     * @return $this
     */
    public function setLocation($uri, $lang, $name)
    {
        $property_name = 'LOCATION' . $uri . $lang . ':';
        $this->properties[$property_name] = $name;
        return $this;
    }

    /**
     * @link https://tools.ietf.org/html/rfc5545#section-3.8.1.11
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(self::STATUS_CANCELLED, self::STATUS_CONFIRMED, self::STATUS_TENTATIVE))) {
            throw new InvalidArgumentException('The parameter "status" is not valid');
        }
        $this->properties['STATUS'] = ':' . $status;
        return $this;
    }

    /**
     * @param string $summary
     * @return $this
     */
    public function setSummary($summary)
    {
        $this->properties['SUMMARY'] = ':' . $this->escape($summary);
        return $this;
    }

    /**
     * @todo
     */
    public function setAttach()
    {
    }

    /**
     * @param string $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->properties['UID'] = ':' . $uid;
        return $this;
    }

    /**
     * @param int $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        if (!is_numeric($priority)) {
            throw new InvalidArgumentException('The parameter "priority" is not numeric');
        }

        $this->properties['PRIORITY'] = ':' . (int)$priority;
        return $this;
    }

    /**
     * @param DateTime $dateTime
     * @return $this
     */
    public function setCreatedDate(DateTime $dateTime)
    {
        $this->properties['CREATED'] = ':' . $dateTime->format(self::DATE_RFC5545);
        return $this;
    }

    /**
     * @param DateTime $dateTime
     * @return $this
     */
    public function setLastModifiedDate(DateTime $dateTime)
    {
        $this->properties['LAST-MODIFIED'] = ':' . $dateTime->format(self::DATE_RFC5545);
        return $this;
    }

    /**
     * @param DateTime $dateTime
     * @return $this
     */
    public function setStartDate(DateTime $dateTime)
    {
        $this->properties['DTSTART'] = ':' . $dateTime->format(self::DATE_RFC5545);
        return $this;
    }

    /**
     * @param DateTime $dateTime
     * @return $this
     */
    public function setEndDate(DateTime $dateTime)
    {
        $this->properties['DTEND'] = ':' . $dateTime->format(self::DATE_RFC5545);
        return $this;
    }

    /**
     * @param Attendee $attendee
     * @return $this
     */
    public function setAttendee(Attendee $attendee)
    {
        $this->properties['ATTENDEE'] = $attendee->toString();
        return $this;
    }

    /**
     * @param Organizer $organizer
     * @return $this
     */
    public function setOrganizer(Organizer $organizer)
    {
        $this->properties['ORGANIZER'] = $organizer->toString();
        return $this;
    }

    /**
     * @param Alarm $alarm
     * @return $this
     */
    public function setAlarm(Alarm $alarm)
    {
        $this->alarm = $alarm;
        return $this;
    }

    /**
     * @return Alarm
     */
    public function getAlarm()
    {
        return $this->alarm;
    }

    /**
     * @throws \Exception
     * @return array
     */
    public function getProperties()
    {
        $properties = array();
        $xProperties = array();

        if ($this->alarm) {
            foreach($this->alarm->getProperties() as $key => $value) {
                $properties[$key] = $value;
            }
            foreach($this->alarm->getXProperties() as $item) {
                $xProperties[] = $item;
            }
        }

        if (count($properties)) {
            $this->properties[] = $properties;
        }
        if (count($xProperties)) {
            $this->xProperties[] = $xProperties;
        }

        return parent::getProperties();
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->properties['URL'] = ':' . $this->formatUri($url);
        return $this;
    }
}
