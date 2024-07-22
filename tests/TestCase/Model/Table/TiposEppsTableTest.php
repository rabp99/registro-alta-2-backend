<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TiposEppsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TiposEppsTable Test Case
 */
class TiposEppsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TiposEppsTable
     */
    protected $TiposEpps;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TiposEpps',
        'app.Estados',
        'app.Areas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TiposEpps') ? [] : ['className' => TiposEppsTable::class];
        $this->TiposEpps = $this->getTableLocator()->get('TiposEpps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TiposEpps);

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
