<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppBooksMigrateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:books:migrate');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Updating timestamps');
        $io->progressStart($this->getManager()->getItemsTotal());

        $this->getManager()->updateCanonicals(function() use ($io){
            $io->progressAdvance();
        });

        $io->progressFinish();
        $io->success('done');
    }

    /**
     * @return \AppBundle\Manager\AudiobookManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.audiobook');
    }
}
