<?php

namespace app\models\source;

use yii\helpers\Html;

class RssSource extends AbstractSource
{
    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    public function getUpdateTime(): ?\DateTime
    {
        if(!isset($this->data['lastBuildDate']))
            return null;

        return new \DateTime($this->data['lastBuildDate']);
    }

    public function getItems(): iterable
    {
        foreach ($this->data['item'] as $entry)
        {
            $item = new SourceItem([
                'uid' => $entry['guid'],
                'url' => $entry['link'],
            ]);

            if(isset($entry['title']))
                $item->title = Html::decode($entry['title']);

            if(isset($entry['description']))
                $item->summary = Html::decode($entry['description']);

            if(isset($entry['pubDate']))
                $item->date = new \DateTime($entry['pubDate']);

            yield $item;
        }
    }
}