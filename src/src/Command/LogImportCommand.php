<?php

namespace App\Command;

use App\Service\LogImporter\LogImporterService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:logs:import',
    description: 'Seeds the database with logs from provided file',
)]
final class LogImportCommand extends Command
{
    public function __construct(
        private readonly LogImporterService $importerService,
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->addArgument(
            name: 'pathname',
            mode: InputArgument::REQUIRED,
            description: 'Path to file with logs'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $pathname = $input->getArgument('pathname');

        $this->importerService->import($pathname);

        $io->success('Import was ended successfully!');

        return Command::SUCCESS;
    }
}
