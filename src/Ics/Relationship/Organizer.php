<?php

namespace Ics\Component;

use Ics\Relationship;

class Organizer extends Relationship
{

    public function toString()
    {
        $string = '';

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
