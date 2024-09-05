<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateParameters extends AbstractMigration
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
        $table = $this->table('parameters');
        $table->addColumn('key', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ])->addColumn('description', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ])->addColumn('value', 'string', [
            'default' => null,
            'limit' => 500,
            'null' => true,
        ])->addColumn('visible', 'boolean', [
            'default' => null,
            'null' => true,
        ])->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ])->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ])->addIndex(['key'], [
            'unique' => true,
            'name' => 'UNIQUE_KEY'
        ]);
        $table->create();
    }
}
