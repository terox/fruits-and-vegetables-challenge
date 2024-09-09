<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Console\Symfony;

use Core\Fruit\Application\Add\FruitAdder;
use Core\Fruit\Domain\FruitId;
use Core\Fruit\Domain\FruitName;
use Core\Fruit\Domain\FruitQuantity;
use Core\Vegetable\Application\Add\VegetableAdder;
use Core\Vegetable\Domain\VegetableId;
use Core\Vegetable\Domain\VegetableName;
use Core\Vegetable\Domain\VegetableQuantity;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RequestLoaderCommand extends Command
{
    public function __construct(
        private readonly FruitAdder $fruitAdder,
        private readonly VegetableAdder $vegetableAdder,
        private readonly \Redis $client
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:load-request')
            ->setDescription('Loads data from request.json and adds it to the application');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $json = file_get_contents(__DIR__ . '/../../../../../request.json');
            $data = json_decode($json, true);
        } catch(\Exception) {
            return Command::FAILURE;
        }

        // Cleans the database to start fresh!
        $this->client->flushAll();

        // Process each item
        foreach ($data as $item) {
            switch($item['type']) {
                case 'fruit':
                    $this->fruitAdder->__invoke(
                        new FruitId($item['id']),
                        new FruitName($item['name']),
                        new FruitQuantity($item['quantity'], $item['unit'])
                    );

                    break;

                case 'vegetable':
                    $this->vegetableAdder->__invoke(
                        new VegetableId($item['id']),
                        new VegetableName($item['name']),
                        new VegetableQuantity($item['quantity'], $item['unit'])
                    );

                    break;

                default:
                    $output->writeln(sprintf('Missing type <%s>', $item['type']));
            }
        }

        $output->writeln('Data has been successfully loaded!');

        return Command::SUCCESS;
    }
}