<?php

use Ics\Calendar;
use Ics\Component\Alarm;
use Ics\Component\Event;

class CalendarTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateCalendar()
    {
        $calendar = new Calendar();
        $actual = $calendar->toString();
        $expected = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ICS//Calendar//EN\r\nCALSCALE:GREGORIAN\r\nMETHOD:PUBLISH\r\nEND:VCALENDAR\r\n";
        $this->assertEquals($expected, $actual);
    }

    public function testEventComponent()
    {
        $now = DateTime::createFromFormat('Y-m-d H:i:s', '2014-10-25 20:26:00');
        $event = new Event();
        //$event->setAttendee();
        $event->setCategories(array('appointment', 'education'));
        $event->setComment('comment');
        $event->setClassification(Event::CLASS_CONFIDENTIAL);
        $event->setCreatedDate($now);
        $event->setDescription('description');
        //$event->setOrganizer();
        $event->setPriority(1);
        $event->setStartDate($now);
        $event->setEndDate($now->modify('+2 hour'));
        $event->setLastModifiedDate($now->modify('+1 hour'));
        $event->setStatus(Event::STATUS_CONFIRMED);
        $event->setSummary('summary');
        $event->setUid('uid');
        $event->setUrl('http://example.com');

        $calendar = new Calendar();
        $calendar->addComponent($event);
        $actual = $calendar->toString();
        $expected = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ICS//Calendar//EN\r\nCALSCALE:GREGORIAN\r\nMETHOD:PUBLISH\r\nBEGIN:VEVENT\r\nCLASS:CONFIDENTIAL\r\nUID:uid\r\nCATEGORIES:APPOINTMENT,EDUCATION\r\nCOMMENT:comment\r\nCREATED:20141025T202600Z\r\nDESCRIPTION:description\r\nPRIORITY:1\r\nDTSTART:20141025T202600Z\r\nDTEND:20141025T222600Z\r\nLAST-MODIFIED:20141025T232600Z\r\nSTATUS:CONFIRMED\r\nSUMMARY:summary\r\nURL:http://example.com\r\nEND:VEVENT\r\nEND:VCALENDAR\r\n";
        $this->assertEquals($expected, $actual);
    }

    public function testAlertComponent()
    {
        $now = DateTime::createFromFormat('Y-m-d H:i:s', '2014-10-25 20:26:00');
        $alert = new Alarm(Alarm::ACTION_DISPLAY);
        //$alert->setAttendee();
        $alert->setDescription('description');
        $alert->setDuration(60);
        $alert->setRepeat(1);
        $alert->setTrigger($now);
        $alert->setSummary('summary');

        $calendar = new Calendar();
        $calendar->addComponent($alert);
        $actual = $calendar->toString();
        $expected = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ICS//Calendar//EN\r\nCALSCALE:GREGORIAN\r\nMETHOD:PUBLISH\r\nBEGIN:VALARM\r\nACTION:DISPLAY\r\nDESCRIPTION:description\r\nDURATION:PT60S\r\nREPEAT:1\r\nTRIGGER;VALUE=DATE-TIME:20141025T202600Z\r\nSUMMARY:summary\r\nEND:VALARM\r\nEND:VCALENDAR\r\n";
        $this->assertEquals($expected, $actual);
    }
}
