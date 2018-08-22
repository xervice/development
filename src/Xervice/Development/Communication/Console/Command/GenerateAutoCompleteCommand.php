<?php


namespace Xervice\Development\Communication\Console\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Business\Model\Command\AbstractCommand;

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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getFacade()->generateAutoComplete();
    }

}