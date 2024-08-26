<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateProductRequestDetails extends AbstractMigration
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
        $table = $this->table('product_request_details');
        $table->addColumn('kits_product_request_id', 'integer', [
            'default' => null,
            'limit' => null,
            'null' => false,
        ])->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => null,
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
                'kits_product_request_id',
                'product_id',
            ]
        )->addForeignKey(
            'kits_product_request_id',
            'kits_product_requests',
            'id',
            [
                'update' => 'NO_ACTION',
                'delete' => 'NO_ACTION',
            ]
        )->addForeignKey(
            'product_id',
            'products',
            'id',
            [
                'update' => 'NO_ACTION',
                'delete' => 'NO_ACTION',
            ]
        )->create();
    }
}
