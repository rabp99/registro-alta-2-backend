<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkersTable Test Case
 */
class WorkersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkersTable
     */
    protected $Workers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Workers',
        'app.WorkerOccupationalGroups',
        'app.WorkerConditions',
        'app.WorkerMedicalSpecialities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Workers') ? [] : ['className' => WorkersTable::class];
        $this->Workers = $this->getTableLocator()->get('Workers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Workers);

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
