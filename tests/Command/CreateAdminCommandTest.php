<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class CreateAdminCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $command = $application->find('app:create-admin');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'email' => 'admin.console@email.com',
            'password' => 'zaq1@WSX'
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
