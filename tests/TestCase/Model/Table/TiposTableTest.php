<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TiposTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TiposTable Test Case
 */
class TiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TiposTable
     */
    protected $Tipos;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Tipos',
        'app.Estados',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Tipos') ? [] : ['className' => TiposTable::class];
        $this->Tipos = $this->getTableLocator()->get('Tipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Tipos);

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
