<?php declare(strict_types=1);

namespace Shopware\Core\Framework\DataAbstractionLayer\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\Event\NestedEvent;
use Shopware\Core\Framework\Event\NestedEventCollection;

class EntityWrittenContainerEvent extends NestedEvent
{
    public const NAME = 'entity.written';

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var NestedEventCollection
     */
    private $events;

    /**
     * @var array
     */
    private $errors;

    public function __construct(Context $context, NestedEventCollection $events, array $errors)
    {
        $this->context = $context;
        $this->events = $events;
        $this->errors = $errors;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getEvents(): ?NestedEventCollection
    {
        return $this->events;
    }

    public function getEventByDefinition(string $definition): ?EntityWrittenEvent
    {
        foreach ($this->events as $event) {
            if (!$event instanceof EntityWrittenEvent) {
                continue;
            }
            if ($event->getDefinition() === $definition) {
                return $event;
            }
        }

        return null;
    }

    public static function createWithWrittenEvents(array $identifiers, Context $context, array $errors): self
    {
        $events = new NestedEventCollection();

        /** @var EntityDefinition|string $definition */
        foreach ($identifiers as $definition => $entityWrittenResult) {
            $events->add(
                new EntityWrittenEvent(
                    $definition,
                    $entityWrittenResult,
                    $context,
                    $errors
                )
            );
        }

        return new self($context, $events, $errors);
    }

    public static function createWithDeletedEvents(array $identifiers, Context $context, array $errors): self
    {
        $events = new NestedEventCollection();

        /** @var EntityDefinition|string $definition */
        foreach ($identifiers as $definition => $data) {
            $events->add(
                new EntityDeletedEvent(
                    $definition,
                    $data,
                    $context,
                    $errors
                )
            );
        }

        return new self($context, $events, $errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getWrittenDefinitions(): array
    {
        return $this->events->map(function (EntityWrittenEvent $event) {
            return $event->getDefinition();
        });
    }
}
