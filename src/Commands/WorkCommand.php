<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Illuminate\Queue\Worker;
use Illuminate\Queue\Failed\NullFailedJobProvider;

class WorkCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('queue:work')
            ->setDescription('Run the Queue Worker instance');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        global $queue;

        $failer = new NullFailedJobProvider;
        $worker = new Worker($queue->getQueueManager());
        

        $connection = 'default';
        $queue      = null;
        $delay      = 0;
        $sleep      = 1;
        $maxTries   = 3;


        while (true) {
            try {
                $result = $worker->pop($connection, $queue, $delay, $sleep, $maxTries);
                // Job processed
                if ($result['job']) {
                    $output->writeln("Job processed: %s, result: %s\n",
                        $result['job']->getJobId(),
                        $result['failed'] ? 'Failed' : 'Success');
                }
            } catch (Exception $e) {
               $output->writeln($e->getTraceAsString());
            } catch (Throwable $e) {
                $output->writeln($e->getTraceAsString());
            }
        }
        
    }
}