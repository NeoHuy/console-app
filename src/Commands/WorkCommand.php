<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Illuminate\Events\Dispatcher;
use Illuminate\Queue\Worker;
use App\Console\Exceptions\Handler;
use Illuminate\Queue\WorkerOptions;


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

        $worker = new Worker($queue->getQueueManager(), new Dispatcher(), new Handler());
        

        $connection = 'default';
        $queue      = 'default';

        while (true) {
            try {
                $result = $worker->runNextJob($connection, $queue, new WorkerOptions(0));
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