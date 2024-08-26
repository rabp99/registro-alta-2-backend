<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\KitsProductRequestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\KitsProductRequestsTable Test Case
 */
class KitsProductRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\KitsProductRequestsTable
     */
    protected $KitsProductRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.KitsProductRequests',
        'app.Kits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('KitsProductRequests') ? [] : ['className' => KitsProductRequestsTable::class];
        $this->KitsProductRequests = $this->getTableLocator()->get('KitsProductRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->KitsProductRequests);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\KitsProductRequestsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\KitsProductRequestsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
