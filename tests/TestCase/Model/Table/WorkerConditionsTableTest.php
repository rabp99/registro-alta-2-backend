<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkerConditionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkerConditionsTable Test Case
 */
class WorkerConditionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkerConditionsTable
     */
    protected $WorkerConditions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.WorkerConditions',
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
        $config = $this->getTableLocator()->exists('WorkerConditions') ? [] : ['className' => WorkerConditionsTable::class];
        $this->WorkerConditions = $this->getTableLocator()->get('WorkerConditions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->WorkerConditions);

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
