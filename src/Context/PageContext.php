<?php

declare(strict_types=1);

namespace Chang\Standard\Context;

use Chang\Context\Page\PageContextInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;

class PageContext implements PageContextInterface
{
    /**
     * @var PageContextInterface
     */
    private $context;

    /**
     * @var PageContextInterface[]
     */
    private $contexts;

    public function __construct(PageContextInterface $context, array $contexts)
    {
        $this->context = $context;
        $this->contexts = $contexts;
    }

    /**
     * @return PageContextInterface
     */
    public function context(): PageContextInterface
    {
        return $this->contexts[$this->getContext()];
    }

    /**
     * {@inheritdoc}
     */
    public function getContext(): string
    {
        return $this->context->getContext();
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $default = null)
    {
        /*if ('seo.locale' === $key) {
            // TODO: localeContext
        }

        if ('seo.lang' === $key) {
            // TODO: localeContext split lang.
        }*/

        return $this->context()->get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value = null): void
    {
        if (is_string($key)) {
            $key = [$key => $value];
        }

        foreach ($key as $item => $value) {
            $this->context()->set($item, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(string $context): void
    {
        $this->context()->setContext($context);
    }

    /**
     * {@inheritdoc}
     */
    public function build(RequestConfiguration $configuration): void
    {
        $this->context()->build($configuration);
    }

    /**
     * {@inheritdoc}
     */
    public function getUser(): ?UserInterface
    {
        return $this->context()->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest(): ?Request
    {
        return $this->context()->getRequest();
    }

    /**
     * {@inheritdoc}
     */
    public function getClientIp(): ?string
    {
        return $this->context()->getClientIp();
    }

    /**
     * {@inheritdoc}
     */
    public function parse(array $parameters, ResourceInterface $resource): array
    {
        return $this->context()->parse($parameters, $resource);
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     *
     * @throws \TypeError
     */
    public function __call($method, $args)
    {
        $context = $this->context();

        try {
            return call_user_func_array([$context, $method], $args);
        } catch (\TypeError $e) {
            try {
                return call_user_func_array([$context, 'get' . ucfirst($method)], $args);
            } catch (\TypeError $e) {
                try {
                    return call_user_func_array([$context, 'is' . ucfirst($method)], $args);
                } catch (\TypeError $e) {
                    return new \RuntimeException(sprintf('Method not found: %s::%s', get_class($context), $method));
                }
            }
        }
    }
}
