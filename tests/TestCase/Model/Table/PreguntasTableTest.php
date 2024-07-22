<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PreguntasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PreguntasTable Test Case
 */
class PreguntasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PreguntasTable
     */
    protected $Preguntas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Preguntas',
        'app.Grupos',
        'app.Estados',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Preguntas') ? [] : ['className' => PreguntasTable::class];
        $this->Preguntas = $this->getTableLocator()->get('Preguntas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Preguntas);

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
