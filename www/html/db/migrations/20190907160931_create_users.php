<?php

use Phinx\Migration\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * create users table
     * - id::integer(11) primary auto increment
     * - name::varchar(15) not null | ユーザー名
     * - password::varchar(255) not null | パスワード
     * - created::datetime | 登録日
     * - modified::datetime | 更新日
     */
    public function change()
    {
        $table = $this->table('users');
        $table
            ->addColumn('name', 'string', ['limit' => 15, 'null' => false, 'comment' => 'ユーザー名'])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false, 'comment' => 'パスワード'])
            ->addColumn('created', 'datetime', ['null' => true, 'comment' => '登録日'])
            ->addColumn('modified', 'datetime', ['null' => true, 'comment' => '更新日'])
            ->create();
    }
}
