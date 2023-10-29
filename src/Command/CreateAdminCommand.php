<?php

declare(strict_types=1);

namespace App\Command;

use App\DTO\User\UserDTO;
use App\Entity\AppUserInterface;
use App\Factory\Entity\EntityFactoryInterface;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EntityFactoryInterface $userFactory
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->userRepository->findOneBy([
            'email' => $input->getArgument('email'),
        ])) {
            $output->writeln('User already exists.');
            return Command::FAILURE;
        }

        /** @var AppUserInterface $user */
        $user = $this->userFactory->create(
            new UserDTO(
                [
                    'email' => $input->getArgument('email'),
                    'password' => $input->getArgument('password'),
                    'firstName' => 'Admin',
                    'lastName' => 'Admin',
                ]
            )
        );

        $user->addAdminRole();

        $this->userRepository->save($user);

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED)
        ;
    }
}
