<?php

declare(strict_types=1);

namespace Chang\Tagging\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\UnitOfWork;
use Chang\Tagging\Model\TaggableInterface;
use Chang\Tagging\Model\TagInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ORMTagSubscriber implements EventSubscriber
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var UnitOfWork
     */
    private $uow;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents(): array
    {
        return ['onFlush'];
    }

    /**
     * @param OnFlushEventArgs $args
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function onFlush(OnFlushEventArgs $args): void
    {
        $this->manager = $args->getEntityManager();
        $this->uow = $this->manager->getUnitOfWork();

        foreach ($this->uow->getScheduledEntityInsertions() as $key => $entity) {
            if ($entity instanceof TaggableInterface) {
                $this->setTags($entity, false);
            }
        }

        foreach ($this->uow->getScheduledEntityUpdates() as $key => $entity) {
            if ($entity instanceof TaggableInterface) {
                $this->setTags($entity, true);
            }
        }
    }

    /**
     * @return TagInterface|object
     */
    private function createNewTag(): TagInterface
    {
        return $this->container->get('tagging.factory.tag')->createNew();
    }

    /**
     * @param TaggableInterface $entity
     * @param bool $update
     *
     * @throws \Doctrine\ORM\ORMException
     */
    private function setTags(TaggableInterface $entity, bool $update = false): void
    {
        $tagNames = $entity->getTagNames();

        if (empty($tagNames) && !$update) {
            return;
        }

        $repository = $this->container->get('tagging.repository.tag');
        $tagClassMetadata = $this->manager->getClassMetadata($repository->getClassName());

        foreach ($tagNames as $tagName) {
            $tag = $repository->findOneBy(['name' => $tagName]);

            if (!$tag) {
                $tag = $this->createNewTag();
                $tag->setName($tagName);
                $this->manager->persist($tag);

                $this->uow->computeChangeSet($tagClassMetadata, $tag);
            }

            $entity->addTag($tag);
        }

        if ($update) {
            foreach ($entity->getTags() as $tag) {
                if (!\in_array($tag->getName(), $tagNames)) {
                    $entity->removeTag($tag);
                }
            }
        }

        $entityClassMetadata = $this->manager->getClassMetadata(\get_class($entity));
        $this->uow->computeChangeSet($entityClassMetadata, $entity);
    }
}
