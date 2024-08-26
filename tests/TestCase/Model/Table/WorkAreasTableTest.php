<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkAreasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkAreasTable Test Case
 */
class WorkAreasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkAreasTable
     */
    protected $WorkAreas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.WorkAreas',
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
        $config = $this->getTableLocator()->exists('WorkAreas') ? [] : ['className' => WorkAreasTable::class];
        $this->WorkAreas = $this->getTableLocator()->get('WorkAreas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->WorkAreas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\WorkAreasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\WorkAreasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
