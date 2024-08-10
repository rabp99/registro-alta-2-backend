<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateKitsProducts extends AbstractMigration
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
        $table = $this->table('kits_products', ['id' => false, 'primary_key' => ['kit_id', 'product_id']])
            ->addColumn('kit_id', 'integer', [
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
            ])
            ->addIndex(
                [
                    'kit_id',
                    'product_id',
                ]
            );
        $table->create();

        $table
            ->addForeignKey(
                'kit_id',
                'kits',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();
    }
}
