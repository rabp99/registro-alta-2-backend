<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsumiblesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsumiblesTable Test Case
 */
class ConsumiblesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsumiblesTable
     */
    protected $Consumibles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Consumibles',
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
        $config = $this->getTableLocator()->exists('Consumibles') ? [] : ['className' => ConsumiblesTable::class];
        $this->Consumibles = $this->getTableLocator()->get('Consumibles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Consumibles);

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
