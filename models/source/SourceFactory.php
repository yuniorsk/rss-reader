<?php

namespace app\models\source;

class SourceFactory
{
    public static function make($data): AbstractSource
    {
        if(isset($data['entry']))
            return new AtomSource($data);

        if (isset($data['channel']))
            return new RssSource($data['channel']);

        throw new \RuntimeException('Unknown feed format');
    }
}