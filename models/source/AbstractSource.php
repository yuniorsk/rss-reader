<?php

namespace app\models\source;

abstract class AbstractSource
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    abstract public function getTitle(): ?string;

    abstract public function getUpdateTime(): ?\DateTime;

    /**
     * @return SourceItem[]
     */
    abstract public function getItems(): iterable;
}