<?php

declare(strict_types=1);

namespace Chang\Tagging\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface TaggableInterface extends ResourceInterface
{
    /**
     * @param TagInterface $tag
     *
     * @return bool
     */
    public function hasTag(TagInterface $tag): bool;

    /**
     * @param TagInterface $tag
     */
    public function addTag(TagInterface $tag): void;

    /**
     * @param TagInterface $tag
     */
    public function removeTag(TagInterface $tag): void;

    /**
     * @return Collection|TagInterface[]
     */
    public function getTags(): Collection;

    /**
     * @return array
     */
    public function getTagNames(): array;

    /**
     * @param null|string $tagsText
     */
    public function setTagsText(?string $tagsText): void;

    /**
     * @return null|string
     */
    public function getTagsText(): ?string;
}
