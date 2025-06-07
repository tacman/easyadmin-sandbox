<?php

declare(strict_types=1);

namespace Adeliom\EasyEditorBundle\Tests\Maker;

use Adeliom\EasyEditorBundle\Maker\MakeBlock;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;

final class MakeBlockTest extends TestCase
{
    public function testCommandBasics(): void
    {
        self::assertSame('make:block', MakeBlock::getCommandName());
        self::assertSame('Creates a new block type', MakeBlock::getCommandDescription());

        $maker = new MakeBlock();
        $command = new Command('test');
        $maker->configureCommand($command, new InputConfiguration());

        $definition = $command->getDefinition();
        self::assertTrue($definition->hasArgument('block-type'));
    }
}
