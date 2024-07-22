<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalidasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalidasTable Test Case
 */
class SalidasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SalidasTable
     */
    protected $Salidas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Salidas',
        'app.Trabajadores',
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
        $config = $this->getTableLocator()->exists('Salidas') ? [] : ['className' => SalidasTable::class];
        $this->Salidas = $this->getTableLocator()->get('Salidas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Salidas);

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
