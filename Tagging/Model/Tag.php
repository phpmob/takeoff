<?php

declare(strict_types=1);

namespace Chang\Tagging\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TimestampableTrait;

class Tag implements TagInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection|TaggableInterface
     */
    private $taggables;

    public function __construct()
    {
        $this->taggables = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): void
    {
        $this->name = trim($name);
    }

    /**
     * {@inheritdoc}
     */
    public function hasTaggable(TaggableInterface $taggable): bool
    {
        return $this->taggables->contains($taggable);
    }

    /**
     * {@inheritdoc}
     */
    public function addTaggable(TaggableInterface $taggable): void
    {
        if (!$this->hasTaggable($taggable)) {
            $this->taggables->add($taggable);
            $taggable->addTag($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeTaggable(TaggableInterface $taggable): void
    {
        if ($this->hasTaggable($taggable)) {
            $this->taggables->removeElement($taggable);
            $taggable->removeTag($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return strval($this->getName());
    }
}
