<?php

declare(strict_types=1);

namespace Chang\Tagging\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface TagInterface extends ResourceInterface, TimestampableInterface
{
    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void;

    /**
     * @param TaggableInterface $taggable
     *
     * @return bool
     */
    public function hasTaggable(TaggableInterface $taggable): bool;

    /**
     * @param TaggableInterface $taggable
     */
    public function addTaggable(TaggableInterface $taggable): void;

    /**
     * @param TaggableInterface $taggable
     */
    public function removeTaggable(TaggableInterface $taggable): void;
}
