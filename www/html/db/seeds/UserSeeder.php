<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Seeder for users table
     */
    public function run()
    {
        $data = [
            [
                'name'     => 'admin',
                'password' => password_hash('pa$$wd', PASSWORD_BCRYPT),
                'created'  => date('Y-m-d H:i:s'),
            ]
        ];

        $this
            ->table('users')
            ->insert($data)
            ->save();
    }
}
