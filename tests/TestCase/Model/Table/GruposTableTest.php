<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GruposTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GruposTable Test Case
 */
class GruposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GruposTable
     */
    protected $Grupos;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Grupos',
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
        $config = $this->getTableLocator()->exists('Grupos') ? [] : ['className' => GruposTable::class];
        $this->Grupos = $this->getTableLocator()->get('Grupos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Grupos);

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
