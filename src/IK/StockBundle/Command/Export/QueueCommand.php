<?php

namespace IK\StockBundle\Command\Export;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use IK\StockBundle\Entity\Export;

class QueueCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this
            ->setName('stock:export:queue')
            ->setDescription('List all queue for export')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('IKStockBundle:Export')->findAll();
        foreach($entities as $entity){
            $output->writeln($entity->getId()."\t".$entity->getUrl()."\t".$entity->getClientKey());
            $browser = $this->getContainer()->get('buzz.browser');
            $response = $browser->post($entity->getUrl().'/test.php', array(), http_build_query(array('products' => array(
                array( 'name'  => 'one' ),
                array( 'name'  => 'two' ),
            ))));
            var_dump($response->getContent());
        }
    }
}