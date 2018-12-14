<?php

declare(strict_types=1);

namespace Chang\Tagging\Bundle;

use Chang\Application\PrependConfigureInterface;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TaggingBundle extends Bundle implements PrependConfigureInterface
{
    /**
     * @var string
     */
    protected $name = 'phpmob_tagging';

    /**
     * @var Extension
     */
    protected $extension;

    public function __construct()
    {
        $this->extension = new TaggingExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigDir(): ?string
    {
        return __DIR__ . '/../Resources/config/vendor';
    }
}
