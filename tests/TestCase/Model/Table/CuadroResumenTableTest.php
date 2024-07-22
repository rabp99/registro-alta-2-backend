<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CuadroResumenTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CuadroResumenTable Test Case
 */
class CuadroResumenTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CuadroResumenTable
     */
    protected $CuadroResumen;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CuadroResumen',
        'app.UserEntregas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CuadroResumen') ? [] : ['className' => CuadroResumenTable::class];
        $this->CuadroResumen = $this->getTableLocator()->get('CuadroResumen', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CuadroResumen);

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
