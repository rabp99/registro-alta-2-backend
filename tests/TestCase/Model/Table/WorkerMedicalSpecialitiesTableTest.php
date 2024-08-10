<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkerMedicalSpecialitiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkerMedicalSpecialitiesTable Test Case
 */
class WorkerMedicalSpecialitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkerMedicalSpecialitiesTable
     */
    protected $WorkerMedicalSpecialities;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.WorkerMedicalSpecialities',
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
        $config = $this->getTableLocator()->exists('WorkerMedicalSpecialities') ? [] : ['className' => WorkerMedicalSpecialitiesTable::class];
        $this->WorkerMedicalSpecialities = $this->getTableLocator()->get('WorkerMedicalSpecialities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->WorkerMedicalSpecialities);

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
