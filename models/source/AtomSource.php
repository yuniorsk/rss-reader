<?php

namespace app\models\source;

use yii\helpers\Html;

class AtomSource extends AbstractSource
{
    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    public function getUpdateTime(): ?\DateTime
    {
        if(!isset($this->data['updated']))
            return null;

        return new \DateTime($this->data['updated']);
    }

    public function getItems(): iterable
    {
        foreach ($this->data['entry'] as $entry)
        {
            $item = new SourceItem([
                'uid' => $entry['id'],
                'url' => $entry['link']['@attributes']['href'],
            ]);

            if(isset($entry['title']))
                $item->title = Html::decode($entry['title']);

            if(isset($entry['author']['name']))
                $item->author = Html::decode($entry['author']['name']);

            if(isset($entry['summary']))
                $item->summary = Html::decode($entry['summary']);

            if(isset($entry['updated']))
                $item->date = new \DateTime($entry['updated']);

            yield $item;
        }
    }
}