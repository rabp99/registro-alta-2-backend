<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReutilizablesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReutilizablesTable Test Case
 */
class ReutilizablesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReutilizablesTable
     */
    protected $Reutilizables;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Reutilizables',
        'app.Tipos',
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
        $config = $this->getTableLocator()->exists('Reutilizables') ? [] : ['className' => ReutilizablesTable::class];
        $this->Reutilizables = $this->getTableLocator()->get('Reutilizables', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Reutilizables);

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
