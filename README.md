ICS
===

PHP Internet Calendaring and Scheduling Core Object (iCalendar)

### Example

```php
$alert = new Alarm(Alarm::ACTION_DISPLAY);
$alert->setDescription('description');
$alert->setDuration(60);
$alert->setRepeat(1);
$alert->setTrigger(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-20 23:59:59'));
$alert->setSummary('summary');

$calendar = new Calendar();
$calendar->addComponent($alert);
echo $calendar->toString(); // "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//ICS//Calendar//EN\r\nCALSCALE:GREGORIAN\r\nMETHOD:PUBLISH\r\nBEGIN:VALARM\r\nACTION:DISPLAY\r\nDESCRIPTION:description\r\nDURATION:PT60S\r\nREPEAT:1\r\nTRIGGER;VALUE=DATE-TIME:20141025T202600Z\r\nSUMMARY:summary\r\nEND:VALARM\r\nEND:VCALENDAR\r\n";
```

