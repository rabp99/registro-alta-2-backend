<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkAreaDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkAreaDetailsTable Test Case
 */
class WorkAreaDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkAreaDetailsTable
     */
    protected $WorkAreaDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.WorkAreaDetails',
        'app.WorkAreas',
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
        $config = $this->getTableLocator()->exists('WorkAreaDetails') ? [] : ['className' => WorkAreaDetailsTable::class];
        $this->WorkAreaDetails = $this->getTableLocator()->get('WorkAreaDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->WorkAreaDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\WorkAreaDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\WorkAreaDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
