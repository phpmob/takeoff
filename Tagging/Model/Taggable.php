<?php

declare(strict_types=1);

namespace Chang\Tagging\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Taggable implements TaggableInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Collection|TagInterface[]
     */
    protected $tags;

    /**
     * @var string|null
     */
    private $tagsText;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function hasTag(TagInterface $tag): bool
    {
        return $this->tags->contains($tag);
    }

    /**
     * {@inheritdoc}
     */
    public function addTag(TagInterface $tag): void
    {
        if (!$this->hasTag($tag)) {
            $this->tags->add($tag);
            $tag->addTaggable($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeTag(TagInterface $tag): void
    {
        if ($this->hasTag($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeTaggable($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function getTagNames(): array
    {
        return empty($this->tagsText) ? [] : array_map('trim', explode(',', $this->tagsText));
    }

    /**
     * {@inheritdoc}
     */
    public function setTagsText(?string $tagsText): void
    {
        $this->tagsText = $tagsText;
    }

    /**
     * {@inheritdoc}
     */
    public function getTagsText(): ?string
    {
        $this->tagsText = implode(', ', $this->tags->toArray());

        return $this->tagsText;
    }
}
