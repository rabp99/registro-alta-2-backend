<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateKitsProductRequests extends AbstractMigration
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
        $table = $this->table('kits_product_requests');
        $table->addColumn('kit_id', 'integer', [
            'default' => null,
            'limit' => null,
            'null' => false,
        ])->addColumn('product_request_year', 'string', [
            'default' => null,
            'limit' => 4,
            'null' => false,
        ])->addColumn('product_request_number', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => false,
        ])->addColumn('amount', 'integer', [
            'default' => 1,
            'limit' => null,
            'null' => false,
        ])->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ])->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ])->addIndex(
            [
                'kit_id',
                'product_request_year',
                'product_request_number',
            ]
        )->addForeignKey(
            'kit_id',
            'kits',
            'id',
            [
                'update' => 'NO_ACTION',
                'delete' => 'NO_ACTION',
            ]
        )->addForeignKey(
            ['product_request_year', 'product_request_number'],
            'product_requests',
            ['year', 'number'],
            [
                'update' => 'NO_ACTION',
                'delete' => 'NO_ACTION',
            ]
        )->create();
    }
}
