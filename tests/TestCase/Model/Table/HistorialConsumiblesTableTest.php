<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HistorialConsumiblesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HistorialConsumiblesTable Test Case
 */
class HistorialConsumiblesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HistorialConsumiblesTable
     */
    protected $HistorialConsumibles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.HistorialConsumibles',
        'app.Consumibles',
        'app.Entregas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('HistorialConsumibles') ? [] : ['className' => HistorialConsumiblesTable::class];
        $this->HistorialConsumibles = $this->getTableLocator()->get('HistorialConsumibles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->HistorialConsumibles);

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
