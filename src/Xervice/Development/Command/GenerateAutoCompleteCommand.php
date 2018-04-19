<?php


namespace Xervice\Development\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Command\AbstractCommand;

/**
 * @method \Xervice\Development\DevelopmentFacade getFacade()
 */
class GenerateAutoCompleteCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('development:generate:auto-completion')
             ->setDescription('Generate ide auto completions');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getFacade()->generateAutoComplete();
    }

}