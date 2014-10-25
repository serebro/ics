<?php

namespace Ics\Component;

use Ics\Component;
use Ics\Relationship;

class Attendee extends Relationship
{

    /**
     * RFC 5545 cutypeparam
     * @var string $calendarUserType
     */
    protected $calendarUserType;

    /**
     * RFC 5545 memberparam
     * @var array $calendarMember array of uri values
     */
    protected $calendarMembers = array();

    /**
     * RFC 5545 roleparam
     * @var string $role
     */
    protected $role;

    /**
     * RFC 5545 partstatparam
     * @var string $participationStatus
     */
    protected $participationStatus;

    /**
     * RFC 5545 rsvpparam
     * @var string $rsvp
     */
    protected $rsvp;

    /**
     * RFC 5545 deltoparam
     * @var array $delegatedTo array of uri values
     */
    protected $delegatedTo = array();

    /**
     * RFC 5545 delfromparam
     * @var array $delegatedFrom array of uri values
     */
    protected $delegatedFrom = array();


    /**
     * RFC 5545 cutypeparam http://tools.ietf.org/html/rfc5545#section-3.2.3
     * @param string $calendarUserType
     *     "INDIVIDUAL"   ; An individual<br>
     *     "GROUP"        ; A group of individuals<br>
     *     "RESOURCE"     ; A physical resource<br>
     *     "ROOM"         ; A room resource<br>
     *     "UNKNOWN"      ; Otherwise not known<br>
     *     x-name         ; Experimental type<br>
     *     iana-token)    ; Other IANA-registered type
     * @return Attendee
     */
    public function setCalendarUserType($calendarUserType)
    {
        $this->calendarUserType = $calendarUserType;
        return $this;
    }

    /**
     * RFC 5545 memberparam http://tools.ietf.org/html/rfc5545#section-3.2.11
     * @param array $calendarMemberUris array of uri values for calendar users ex. array('sue@example.com', 'joe@example.com')
     * @return Attendee
     */
    public function setCalendarMembers($calendarMemberUris)
    {
        foreach ($calendarMemberUris as &$uri) {
            $uri = $this->formatUri($uri);
        }

        $this->calendarMembers = $calendarMemberUris;
        return $this;
    }

    /**
     * RFC 5545 memberparam http://tools.ietf.org/html/rfc5545#section-3.2.11
     * @param string $uri
     * @return Attendee
     */
    public function addCalendarMember($uri)
    {
        $this->calendarMembers[] = $this->formatUri($uri);
        return $this;
    }

    /**
     * RFC 5545 roleparam http://tools.ietf.org/html/rfc5545#section-3.2.16
     * @param string $role
     *     "CHAIR"             ; Indicates chair of the calendar entity <br>
     *     "REQ-PARTICIPANT"   ; Indicates a participant whose participation is required <br>
     *     "OPT-PARTICIPANT"   ; Indicates a participant whose participation is optional <br>
     *     "NON-PARTICIPANT"   ; Indicates a participant who is copied for information purposes only <br>
     *     x-name              ; Experimental role
     *     iana-token         ; Other IANA role
     * @return Attendee
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * RFC 5545 partstatparam http://tools.ietf.org/html/rfc5545#section-3.2.12
     * @param string $participationStatus
     *     Example values for an Event: <br>
     *     "NEEDS-ACTION"     ; Event needs action <br>
     *     "ACCEPTED"         ; Event accepted <br>
     *     "DECLINED"         ; Event declined <br>
     *     "TENTATIVE"        ; Event tentatively accepted <br>
     *     "DELEGATED"        ; Event delegated
     * @return Attendee
     */
    public function setParticipationStatus($participationStatus)
    {
        $this->participationStatus = $participationStatus;
        return $this;
    }

    /**
     * RFC 5545 rsvpparam http://tools.ietf.org/html/rfc5545#section-3.2.17
     * @param string $rsvp "TRUE" or "FALSE"
     * @return Attendee
     */
    public function setRsvp($rsvp)
    {
        $this->rsvp = $rsvp;
        return $this;
    }

    /**
     * RFC 5545 deltoparam http://tools.ietf.org/html/rfc5545#section-3.2.5
     * @param array $delegatedToUris array of uri values for calendar users ex. array('sue@example.com', 'joe@example.com')
     * @return Attendee
     */
    public function setDelegatedTo(array $delegatedToUris)
    {
        foreach ($delegatedToUris as &$uri) {
            $uri = $this->formatUri($uri);
        }

        $this->delegatedTo = $delegatedToUris;
        return $this;
    }

    /**
     * @param string $uri uri value for calendar users ex. 'mary@example.com'
     * @return Attendee
     */
    public function addDelegatedTo($uri)
    {
        $this->delegatedTo[] = $this->formatUri($uri);
        return $this;
    }

    /**
     * RFC 5545 delfromparam http://tools.ietf.org/html/rfc5545#section-3.2.4
     * @param array $delegatedFromUris array of uri values for calendar users ex. array('sue@example.com', 'joe@example.com')
     * @return Attendee
     */
    public function setDelegatedFrom(array $delegatedFromUris)
    {
        foreach ($delegatedFromUris as &$uri) {
            $uri = $this->formatUri($uri);
        }

        $this->delegatedFrom = $delegatedFromUris;
        return $this;
    }

    /**
     * @param string $uri uri value for calendar users ex. 'mary@example.com'
     * @return Attendee
     */
    public function addDelegatedFrom($uri)
    {
        $this->delegatedFrom[] = $this->formatUri($uri);
        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $string = '';

        if ($this->calendarUserType) {
            $string .= ';CUTYPE=' . $this->calendarUserType;
        }

        if (count($this->calendarMembers)) {
            $string .= ';MEMBER="' . implode('","', $this->calendarMembers) . '"';
        }

        if ($this->role) {
            $string .= ';ROLE=' . $this->role;
        }

        if ($this->participationStatus) {
            $string .= ';PARTSTAT=' . $this->participationStatus;
        }

        if ($this->rsvp) {
            $string .= ';RSVP=' . $this->rsvp;
        }

        if (count($this->delegatedTo)) {
            $string .= ';DELEGATED-TO="' . implode('","', $this->delegatedTo) . '"';
        }

        if (count($this->delegatedFrom)) {
            $string .= ';DELEGATED-FROM="' . implode('","', $this->delegatedFrom) . '"';
        }

        if ($this->sentBy) {
            $string .= ';SENT-BY="' . $this->sentBy . '"';
        }

        if ($this->name) {
            $string .= ';CN=' . $this->name;
        }

        if ($this->directory) {
            $string .= ';DIR="' . $this->directory . '"';
        }

        if ($this->language) {
            $string .= ';LANGUAGE=' . $this->language;
        }

        $string .= ':' . $this->value;

        return $string;
    }
}
