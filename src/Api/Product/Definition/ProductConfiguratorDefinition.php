<?php declare(strict_types=1);

namespace Shopware\Api\Product\Definition;

use Shopware\Api\Configuration\Definition\ConfigurationGroupOptionDefinition;
use Shopware\Api\Entity\EntityDefinition;
use Shopware\Api\Entity\EntityExtensionInterface;
use Shopware\Api\Entity\Field\ArrayField;
use Shopware\Api\Entity\Field\FkField;
use Shopware\Api\Entity\Field\IdField;
use Shopware\Api\Entity\Field\ManyToOneAssociationField;
use Shopware\Api\Entity\Field\PriceRulesField;
use Shopware\Api\Entity\Field\ReferenceVersionField;
use Shopware\Api\Entity\Field\VersionField;
use Shopware\Api\Entity\FieldCollection;
use Shopware\Api\Entity\Write\Flag\PrimaryKey;
use Shopware\Api\Entity\Write\Flag\Required;
use Shopware\Api\Entity\Write\Flag\WriteOnly;
use Shopware\Api\Product\Collection\ProductConfiguratorBasicCollection;
use Shopware\Api\Product\Event\ProductConfigurator\ProductConfiguratorDeletedEvent;
use Shopware\Api\Product\Event\ProductConfigurator\ProductConfiguratorWrittenEvent;
use Shopware\Api\Product\Repository\ProductConfiguratorRepository;
use Shopware\Api\Product\Struct\ProductConfiguratorBasicStruct;

class ProductConfiguratorDefinition extends EntityDefinition
{
    /**
     * @var FieldCollection
     */
    protected static $primaryKeys;

    /**
     * @var FieldCollection
     */
    protected static $fields;

    /**
     * @var EntityExtensionInterface[]
     */
    protected static $extensions = [];

    public static function getEntityName(): string
    {
        return 'product_configurator';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            (new IdField('id', 'id'))->setFlags(new PrimaryKey(), new Required()),
            new VersionField(),
            (new FkField('product_id', 'productId', ProductDefinition::class))->setFlags(new Required()),
            new ReferenceVersionField(ProductDefinition::class),
            (new FkField('configuration_option_id', 'configurationOptionId', ConfigurationGroupOptionDefinition::class))->setFlags(new Required()),
            new ReferenceVersionField(ConfigurationGroupOptionDefinition::class),
            new ArrayField('price', 'price'),
            new PriceRulesField('prices', 'prices'),
            (new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, false))->setFlags(new WriteOnly()),
            new ManyToOneAssociationField('configurationOption', 'configuration_option_id', ConfigurationGroupOptionDefinition::class, true),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return ProductConfiguratorRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return ProductConfiguratorBasicCollection::class;
    }

    public static function getDeletedEventClass(): string
    {
        return ProductConfiguratorDeletedEvent::class;
    }

    public static function getWrittenEventClass(): string
    {
        return ProductConfiguratorWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return ProductConfiguratorBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return null;
    }
}