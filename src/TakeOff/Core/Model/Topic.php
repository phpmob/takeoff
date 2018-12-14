<?php

declare(strict_types=1);

namespace TakeOff\Core\Model;

use Chang\Tagging\Model\Taggable;

class Topic extends Taggable
{
    /**
     * @var string|null
     */
    private $title;

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
}
