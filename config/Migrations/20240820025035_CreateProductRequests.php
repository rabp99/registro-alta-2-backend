<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateProductRequests extends AbstractMigration
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
        $table = $this->table('product_requests', ['id' => false, 'primary_key' => ['year', 'number']])
            ->addColumn('year', 'string', [
                'default' => null,
                'limit' => 4,
                'null' => false,
            ])
            ->addColumn('number', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('document_type', 'string', [
                'default' => "DNI",
                'limit' => 5,
                'null' => false,
            ])
            ->addColumn('document_number', 'string', [
                'default' => null,
                'limit' => 8,
                'null' => false,
            ])
            ->addColumn('work_area_detail_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('handled_by_user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('attention_date', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('signature_path', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('created_by', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified_by', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'year',
                    'number',
                    'document_type',
                    'document_number',
                    'work_area_detail_id',
                    'handled_by_user_id',
                    'created_by',
                    'modified_by'
                ]
            )->addForeignKey(
                ['document_type', 'document_number'],
                'workers',
                ['document_type', 'document_number'],
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
            )->addForeignKey(
                'handled_by_user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'created_by',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'modified_by',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            );
        $table->create();
    }
}
