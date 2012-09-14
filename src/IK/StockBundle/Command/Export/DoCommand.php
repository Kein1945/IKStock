<?php

namespace IK\StockBundle\Command\Export;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use IK\StockBundle\Entity\Export;

class DoCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this
            ->setName('stock:export:do')
            ->setDescription('Start export for :id record')
            ->addArgument('id', InputArgument::REQUIRED, 'What record do you want synchronize?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $id = $input->getArgument('id');
        $entity = $em->getRepository('IKStockBundle:Export')->find($id);
        if(!$entity){
            $output->writeln("<error>There is no any record with id $id</error>");
            return;
        }

        $output->writeln($entity->getId()."\t".$entity->getUrl()."\t".$entity->getClientKey());

        $export = $this->getContainer()->get('stock.export.factory');

        $process = $export->process($entity);
        $result = $process->start();
        var_dump($result);
        var_dump($process->getResponse());
        return;
        $browser = $this->getContainer()->get('buzz.browser');
        $response = $browser->post($entity->getUrl().'/test.php', array(), http_build_query(array('products' => array(
            array( 'name'  => 'one' ),
            array( 'name'  => 'two' ),
        ))));
        var_dump($response->getContent());
    }
};
