<?php declare(strict_types=1);

namespace Shopware\Core\Content;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Content extends Bundle
{
    protected $name = 'Content';

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/DependencyInjection/'));
        $loader->load('category.xml');
        $loader->load('media.xml');
        $loader->load('product.xml');
        $loader->load('navigation.xml');
        $loader->load('newsletter_receiver.xml');
        $loader->load('rule.xml');
        $loader->load('product_stream.xml');
        $loader->load('property.xml');
        $loader->load('cms.xml');
        $loader->load('mail_template.xml');
    }
}
