<?php

declare(strict_types=1);

use Migrations\AbstractMigration;
use Cake\ORM\TableRegistry;

class InsertKitsProducts extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $data = [];
        $file = fopen('config/data/kits_products.csv', 'r');

        // Skip the header row if your CSV file has one
        fgetcsv($file);

        while (($row = fgetcsv($file, null, ',')) !== FALSE) {
            [$kitId, $productId] = $this->getPrimaryKey($row);
            $data[] = [
                'kit_id' => $kitId,
                'product_id' => $productId,
            ];
        }

        fclose($file);

        $table = $this->table('kits_products');
        $table->insert($data)->saveData();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function down()
    {
        $this->execute('TRUNCATE TABLE kits_products');
    }

    public function getPrimaryKey($row)
    {
        $kitsTable = TableRegistry::getTableLocator()->get('kits');

        $kit = $kitsTable->find()
            ->where(['description' => $row[0]])
            ->first();

        $productsTable = TableRegistry::getTableLocator()->get('products');

        $product = $productsTable->find()
            ->where(['description' => $row[1]])
            ->first();

        return [$kit->id, $product->id];
    }
}
