<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkerOccupationalGroupsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkerOccupationalGroupsTable Test Case
 */
class WorkerOccupationalGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkerOccupationalGroupsTable
     */
    protected $WorkerOccupationalGroups;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.WorkerOccupationalGroups',
        'app.Workers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('WorkerOccupationalGroups') ? [] : ['className' => WorkerOccupationalGroupsTable::class];
        $this->WorkerOccupationalGroups = $this->getTableLocator()->get('WorkerOccupationalGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->WorkerOccupationalGroups);

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
}
