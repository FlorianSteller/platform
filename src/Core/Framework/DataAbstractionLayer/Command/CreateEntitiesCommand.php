<?php declare(strict_types=1);

namespace Shopware\Core\Framework\DataAbstractionLayer\Command;

use Shopware\Core\Framework\DataAbstractionLayer\DefinitionRegistry;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateEntitiesCommand extends Command
{
    /**
     * @var EntityGenerator
     */
    private $entityGenerator;

    /**
     * @var DefinitionRegistry
     */
    private $registry;

    /**
     * @var string
     */
    private $dir;

    public function __construct(
        EntityGenerator $entityGenerator,
        DefinitionRegistry $registry,
        string $rootDir
    ) {
        parent::__construct();
        $this->registry = $registry;
        $this->dir = $rootDir . '/../schema/';
        $this->entityGenerator = $entityGenerator;
    }

    protected function configure()
    {
        $this->setName('dal:create:entities');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('DAL generate schema');

        $entities = $this->registry->getDefinitions();
        $classes = [];

        /** @var string|EntityDefinition $entity */
        foreach ($entities as $entity) {
            $domain = explode('_', $entity::getEntityName());
            $domain = array_shift($domain);
            $classes[$domain][] = $this->entityGenerator->generate($entity);
        }

        $io->success('Created schema in ' . $this->dir);

        foreach ($classes as $domain => $domainClasses) {
            foreach ($domainClasses as $entityClasses) {
                if (empty($entityClasses)) {
                    continue;
                }
                foreach ($entityClasses as $file => $content) {
                    file_put_contents($this->dir . '/' . $domain . '/' . $file, $content);
                }
            }
        }
    }
}
