<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductRequestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductRequestsTable Test Case
 */
class ProductRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductRequestsTable
     */
    protected $ProductRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ProductRequests',
        'app.WorkAreas',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductRequests') ? [] : ['className' => ProductRequestsTable::class];
        $this->ProductRequests = $this->getTableLocator()->get('ProductRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProductRequests);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProductRequestsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ProductRequestsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
