<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RespuestasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RespuestasTable Test Case
 */
class RespuestasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RespuestasTable
     */
    protected $Respuestas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Respuestas',
        'app.Cuestionarios',
        'app.Preguntas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Respuestas') ? [] : ['className' => RespuestasTable::class];
        $this->Respuestas = $this->getTableLocator()->get('Respuestas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Respuestas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
