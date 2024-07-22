<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CuestionariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CuestionariosTable Test Case
 */
class CuestionariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CuestionariosTable
     */
    protected $Cuestionarios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cuestionarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cuestionarios') ? [] : ['className' => CuestionariosTable::class];
        $this->Cuestionarios = $this->getTableLocator()->get('Cuestionarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cuestionarios);

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
}
