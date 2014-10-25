<?php

namespace Ics\Component;

use DateInterval;
use DateTime;
use Ics\Component;
use InvalidArgumentException;

class Alarm extends Component
{

    const ACTION_AUDIO = 'audioprop';
    const ACTION_DISPLAY = 'dispprop';
    const ACTION_EMAIL = 'emailprop';

    protected $component_name = 'VALARM';

    protected $action = '';


    public function __construct($action)
    {
        parent::__construct();

        if (!in_array($action, array(self::ACTION_AUDIO, self::ACTION_DISPLAY, self::ACTION_EMAIL))) {
            throw new InvalidArgumentException('The attribute "action" is not valid');
        }

        $this->action = $action;
    }

    /**
     * @param DateInterval|DateTime $dateTime
     * @return $this
     */
    public function setTrigger($dateTime)
    {
        if ($dateTime instanceof DateTime) {
            $value = ';VALUE=DATE-TIME:' . $dateTime->format(self::DATE_RFC5545);
        } else if ($dateTime instanceof DateInterval) {
            $value = ';RELATED=END:' . $this->formatInterval($dateTime);
        } else {
            throw new \InvalidArgumentException('The parameter "dateTime" is not valid');
        }

        $this->properties['TRIGGER'] = $value;
        return $this;
    }

    /**
     * @param int $repeat
     * @return $this
     */
    public function setRepeat($repeat)
    {
        if (!is_numeric($repeat)) {
            throw new InvalidArgumentException('The argument "repeat" is not numeric');
        }

        $this->properties['REPEAT'] = ':' . (int)$repeat;
        return $this;
    }

    /**
     * @param int|DateInterval $duration
     * @return $this
     */
    public function setDuration($duration)
    {
        if (!is_numeric($duration) && !$duration instanceof DateInterval) {
            throw new InvalidArgumentException('The argument "seconds" is not numeric or DateInterval');
        }

        if (is_numeric($duration)) {
            $duration = DateInterval::createFromDateString("$duration seconds");
        }

        $this->properties['DURATION'] = ':' . $this->formatInterval($duration);
        return $this;
    }

    /**
     * @param string $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->properties['ACTION'] = ':' . $action;
        return $this;
    }

    /**
     * @param string $summary
     * @return $this
     */
    public function setSummary($summary)
    {
        $this->properties['SUMMARY'] = ':' . $summary;
        return $this;
    }

    /**
     * @todo
     */
    public function setAttach()
    {
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
     * @throws \Exception
     * @return array
     */
    public function getProperties()
    {
        if ($this->action === self::ACTION_AUDIO && empty($this->properties['TRIGGER'])) {
            throw new \Exception();
        }

        if (!((empty($this->properties['DURATION']) && empty($this->properties['REPEAT'])) || (!empty($this->properties['DURATION']) && !empty($this->properties['REPEAT'])))) {
            throw new \Exception();
        }

        return parent::getProperties();
    }
}
