<?php declare(strict_types=1);

namespace Shopware\Docs\Inspection;

use Symfony\Component\Finder\SplFileInfo;

class ModuleTag
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $marker = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addMarkers(string $name, iterable $files): self
    {
        foreach ($files as $file) {
            $this->addMarker($name, $file);
        }

        return $this;
    }

    public function addMarker(string $name, SplFileInfo $file): void
    {
        if (!isset($this->marker[$name])) {
            $this->marker[$name] = [];
        }

        $this->marker[$name][] = $file;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function marker(): array
    {
        return $this->marker;
    }

    public function valid(): bool
    {
        return count($this->marker()) > 0;
    }
}
