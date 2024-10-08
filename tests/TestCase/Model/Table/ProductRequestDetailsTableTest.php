<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductRequestDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductRequestDetailsTable Test Case
 */
class ProductRequestDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductRequestDetailsTable
     */
    protected $ProductRequestDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ProductRequestDetails',
        'app.KitsProductRequests',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductRequestDetails') ? [] : ['className' => ProductRequestDetailsTable::class];
        $this->ProductRequestDetails = $this->getTableLocator()->get('ProductRequestDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProductRequestDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProductRequestDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ProductRequestDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
