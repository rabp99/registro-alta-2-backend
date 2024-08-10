<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateKits extends AbstractMigration
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
        $table = $this->table('kits')
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])->addColumn('status', 'boolean', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
            ]);
        $table->create();
    }
}
