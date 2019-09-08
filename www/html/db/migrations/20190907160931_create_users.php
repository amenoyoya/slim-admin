<?php

use Phinx\Migration\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * create users table
     * - id::integer(11) primary auto increment
     * - name::varchar(15) not null | ユーザー名
     * - password::varchar(255) not null | パスワード
     * - created_at::datetime auto | 登録日
     * - updated_at::datetime auto | 更新日
     */
    public function change()
    {
        $table = $this->table('users');
        $table
            ->addColumn('name', 'string', ['limit' => 15, 'null' => false, 'comment' => 'ユーザー名'])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false, 'comment' => 'パスワード'])
            ->addColumn('created_at', 'datetime', ['null' => true, 'comment' => '登録日'])
            ->addColumn('updated_at', 'datetime', ['null' => true, 'comment' => '更新日'])
            ->create();
    }
}
