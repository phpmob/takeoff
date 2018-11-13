<?php

declare(strict_types=1);

namespace TakeOff\Core;

use Chang\Application\PrependConfigureInterface;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreBundle extends Bundle implements PrependConfigureInterface
{
    /**
     * @var string
     */
    protected $name = 'takeoff_core';

    /**
     * @var Extension
     */
    protected $extension;

    public function __construct()
    {
        $this->extension = new CoreExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigDir(): ?string
    {
        return __DIR__ . '/Resources/config/vendor';
    }
}
