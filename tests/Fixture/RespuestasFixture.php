<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RespuestasFixture
 */
class RespuestasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'cuestionario_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pregunta_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor' => ['type' => 'char', 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_respuestas_cuestionarios1_idx' => ['type' => 'index', 'columns' => ['cuestionario_id'], 'length' => []],
            'fk_respuestas_preguntas1_idx' => ['type' => 'index', 'columns' => ['pregunta_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'cuestionario_id', 'pregunta_id'], 'length' => []],
            'fk_respuestas_preguntas1' => ['type' => 'foreign', 'columns' => ['pregunta_id'], 'references' => ['preguntas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_respuestas_cuestionarios1' => ['type' => 'foreign', 'columns' => ['cuestionario_id'], 'references' => ['cuestionarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
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
                'id' => 1,
                'cuestionario_id' => 1,
                'pregunta_id' => 1,
                'valor' => '',
            ],
        ];
        parent::init();
    }
}
