<?php

namespace Ics;

class Stream
{

    const LINE_LENGTH = 70;

    protected $stream = '';

    protected $encoding = 'UTF-8';


    public function __construct($encoding = 'UTF-8')
    {
        $this->encoding = $encoding;
    }

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
        if ($length > self::LINE_LENGTH + 5) {
            $start = 0;

            while ($start < $length) {
                $block .= mb_strcut($item, $start, self::LINE_LENGTH, $this->encoding);
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
