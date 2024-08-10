<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkplacesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkplacesTable Test Case
 */
class WorkplacesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkplacesTable
     */
    protected $Workplaces;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Workplaces',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Workplaces') ? [] : ['className' => WorkplacesTable::class];
        $this->Workplaces = $this->getTableLocator()->get('Workplaces', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Workplaces);

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
