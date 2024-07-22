<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntregasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntregasTable Test Case
 */
class EntregasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EntregasTable
     */
    protected $Entregas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Entregas',
        'app.Consumibles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Entregas') ? [] : ['className' => EntregasTable::class];
        $this->Entregas = $this->getTableLocator()->get('Entregas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Entregas);

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
