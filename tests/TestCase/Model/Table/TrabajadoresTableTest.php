<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrabajadoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrabajadoresTable Test Case
 */
class TrabajadoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TrabajadoresTable
     */
    protected $Trabajadores;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Trabajadores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Trabajadores') ? [] : ['className' => TrabajadoresTable::class];
        $this->Trabajadores = $this->getTableLocator()->get('Trabajadores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Trabajadores);

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
