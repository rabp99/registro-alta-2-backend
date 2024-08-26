<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateKitsWorkAreaDetails extends AbstractMigration
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
        $table = $this->table('kits_work_area_details');
        $table->addColumn('kit_id', 'integer', [
            'default' => null,
            'limit' => null,
            'null' => false,
        ])->addColumn('work_area_detail_id', 'integer', [
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
                'kit_id',
                'work_area_detail_id',
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
            'work_area_detail_id',
            'work_area_details',
            'id',
            [
                'update' => 'NO_ACTION',
                'delete' => 'NO_ACTION',
            ]
        )->create();
    }
}
