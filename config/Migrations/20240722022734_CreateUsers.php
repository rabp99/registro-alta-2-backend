<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        /*
        $this->table('users')
            ->addColumn('status', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])->addColumn('username', 'string', [
                'default' => null,
                'limit' => 90,
                'null' => false,
            ])->addColumn('password', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => false,
            ])->addColumn('last_name1', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => false,
            ])->addColumn('last_name2', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => false,
            ])->addColumn('role_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )->addIndex(
                [
                    'role_id',
                ]
            )->addForeignKey(
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->create();
    
    
    */
    }
}
