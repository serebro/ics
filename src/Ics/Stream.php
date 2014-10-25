<?php

namespace Ics;

class Stream
{

    const LINE_LENGTH = 70;

    protected $stream = '';


    public function reset()
    {
        $this->stream = '';
        return $this;
    }

    public function get()
    {
        return $this->stream;
    }

    /**
     * @param string $item
     * @return $this
     */
    public function add($item)
    {
        //get number of bytes
        $length = strlen($item);

        $block = '';

        if ($length > 75) {
            $start = 0;

            while ($start < $length) {
                $block .= mb_strcut($item, $start, self::LINE_LENGTH, 'UTF-8');
                $start = $start + self::LINE_LENGTH;

                //add space if not last line
                if ($start < $length) {
                    $block .= Util::EOL . ' ';
                }
            }
        } else {
            $block = $item;
        }

        $this->stream .= $block . Util::EOL;

        return $this;
    }
}
