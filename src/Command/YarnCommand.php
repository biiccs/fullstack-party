<?php
/**
 * Created by PhpStorm.
 * User: biiccs
 * Date: 18.3.4
 * Time: 13.40
 */

namespace App\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class YarnCommand
 * @package App\Command
 */
class YarnCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('yarn')
            ->setDescription('Build web assets under a public build directory');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = new Process('yarn install');
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        $env = getenv('APP_ENV');
        $yarnEnv = $env == 'prod' ? 'production' : 'dev';

        $process = new Process(sprintf('yarn encore %s', $yarnEnv));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}