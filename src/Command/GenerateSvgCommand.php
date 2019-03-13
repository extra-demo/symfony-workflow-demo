<?php

namespace App\Command;

use App\Entity\Post;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Workflow\Registry;

class GenerateSvgCommand extends Command
{
    protected static $defaultName = 'generateSvg';
    
    /**
     * @var Registry
     */
    protected $registry;
    
    /**
     * GenerateSvgCommand constructor.
     * @param Registry $registry
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(Registry $registry)
    {
        parent::__construct(null);
        $this->registry = $registry;
    }
    
    protected function configure()
    {
        $this
            ->setDescription('生成所有的图。。。。')
        ;
    }
    
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Symfony\Component\Process\Exception\LogicException
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Workflow\Exception\LogicException
     * @throws \Symfony\Component\Workflow\Exception\InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = [
            'draft',
            'review',
            'rejected',
            'published',
        ];
        $subject = new Post();
        $workflow = $this->registry->get($subject);
        $data = $workflow->getDefinition()->getPlaces();
        /** @var Post $post */
        foreach ($data as $place) {
            $process = Process::fromShellCommandline("php bin/console workflow:dump blog_publishing {$place} | dot -Tsvg -o public/graph-{$place}.svg");
            $process->run();
            $output->writeln("build-place: {$place}");
        }
    }
}
