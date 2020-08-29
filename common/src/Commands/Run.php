<?php namespace Com\Clay\Common\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class Run extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run php file with system env support.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('php_file');
        if (is_file($file)) {
            define('ERROR_NOT_REPORT', true);

            include $file;
        } else {
            $this->error("file '{$file}' not found!");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('php_file', InputArgument::REQUIRED, 'The php file to run with Laputa.'),
        );
    }
}
