<?php

namespace Subbly\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Subbly\Subbly;

class CreateAdminUserCommand extends Command {

    protected $name = 'subbly:create-admin-user';

    protected $description = 'Create a admin user by cli.';

    public function fire()
    {
        $email    = $this->option('email');
        $password = $this->option('password');

        Subbly::api('subbly.user')->create(array(
            'firstname' => 'Admin',
            'lastname'  => 'Admin',
            'email'     => $email,
            'password'  => $password,
        ));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            // array('example', InputArgument::REQUIRED, 'An example argument.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('email', null, InputOption::VALUE_REQUIRED, 'User email'),
            array('password', null, InputOption::VALUE_REQUIRED, 'User password'),
        );
    }
}
