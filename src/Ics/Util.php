<?php

namespace Ics;

use DateInterval;

class Util
{
    const EOL = "\r\n";

    const DATE_RFC5545 = 'Ymd\THis\Z'; // UTC time
    const INTERVAL_ISO8601 = '';

    /**
     * @param DateInterval $interval
     * @return string
     */
    public function formatInterval($interval)
    {
        $result = 'P';

        if ($interval->y) {
            $result .= $interval->y . 'Y';
        }

        if ($interval->m) {
            $result .= $interval->m . 'M';
        }

        if ($interval->d) {
            $result .= $interval->d . 'D';
        }

        if ($interval->h || $interval->i || $interval->s) {
            $result .= 'T';

            if ($interval->h) {
                $result .= $interval->h . 'H';
            }

            if ($interval->i) {
                $result .= $interval->i . 'M';
            }

            if ($interval->s) {
                $result .= $interval->s . 'S';
            }
        }

        return $result;
    }

    protected function formatUri($uri)
    {
        if (strpos($uri, '@') && stripos($uri, 'mailto:') === false) {
            $uri = 'mailto:' . $uri;
        }
        $uri = htmlspecialchars($uri);
        return $uri;
    }

    /**
     * @param string $string
     * @return string
     */
    protected function escape($string) {
        $eol = "\n";
        $string = preg_replace("/[\r\n]+/", $eol, $string);
        $string = preg_replace('/\<br(\s*)?\/?\>/i', $eol, $string);
        $string = strip_tags($string);
        $string = html_entity_decode($string, ENT_QUOTES);
        return preg_replace('/([\,;])/','\\\$1', $string);
    }

}
