<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CuadroResumenFixture
 */
class CuadroResumenFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'cuadro_resumen';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'user_entrega_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'fecha_entrega_date_solicitud' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'nombre_completo' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'username' => ['type' => 'string', 'length' => 90, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'epp_0' => ['type' => 'decimal', 'length' => 32, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'epp_2' => ['type' => 'decimal', 'length' => 32, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'epp_5' => ['type' => 'decimal', 'length' => 32, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'epp_8' => ['type' => 'decimal', 'length' => 32, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'respiradores' => ['type' => 'decimal', 'length' => 32, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'n95' => ['type' => 'decimal', 'length' => 32, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'lentes' => ['type' => 'decimal', 'length' => 32, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'filtros' => ['type' => 'decimal', 'length' => 32, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'mandilones_tela' => ['type' => 'decimal', 'length' => 23, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'pantalones_tela' => ['type' => 'decimal', 'length' => 23, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'chaquetas_tela' => ['type' => 'decimal', 'length' => 23, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_options' => [
            'engine' => null,
            'collation' => null
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'user_entrega_id' => 1,
                'fecha_entrega_date_solicitud' => '2021-07-20',
                'nombre_completo' => 'Lorem ipsum dolor sit amet',
                'username' => 'Lorem ipsum dolor sit amet',
                'epp_0' => 1.5,
                'epp_2' => 1.5,
                'epp_5' => 1.5,
                'epp_8' => 1.5,
                'respiradores' => 1.5,
                'n95' => 1.5,
                'lentes' => 1.5,
                'filtros' => 1.5,
                'mandilones_tela' => 1.5,
                'pantalones_tela' => 1.5,
                'chaquetas_tela' => 1.5,
            ],
        ];
        parent::init();
    }
}
