<?php declare(strict_types=1);

namespace Shopware\Core\Content\Property;

use Shopware\Core\Content\Property\Aggregate\PropertyGroupOption\PropertyGroupOptionCollection;
use Shopware\Core\Content\Property\Aggregate\PropertyGroupTranslation\PropertyGroupTranslationCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class PropertyGroupEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string
     */
    protected $displayType;

    /**
     * @var string
     */
    protected $sortingType;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var PropertyGroupOptionCollection|null
     */
    protected $options;

    /**
     * @var PropertyGroupTranslationCollection|null
     */
    protected $translations;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updatedAt;

    /**
     * @var array|null
     */
    protected $attributes;

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getOptions(): ?PropertyGroupOptionCollection
    {
        return $this->options;
    }

    public function setOptions(PropertyGroupOptionCollection $options): void
    {
        $this->options = $options;
    }

    public function getTranslations(): ?PropertyGroupTranslationCollection
    {
        return $this->translations;
    }

    public function setTranslations(PropertyGroupTranslationCollection $translations): void
    {
        $this->translations = $translations;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDisplayType(): string
    {
        return $this->displayType;
    }

    public function setDisplayType(string $displayType): void
    {
        $this->displayType = $displayType;
    }

    public function getSortingType(): string
    {
        return $this->sortingType;
    }

    public function setSortingType(string $sortingType): void
    {
        $this->sortingType = $sortingType;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function setAttributes(?array $attributes): void
    {
        $this->attributes = $attributes;
    }
}
