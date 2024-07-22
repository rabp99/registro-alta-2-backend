<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreasTable Test Case
 */
class AreasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreasTable
     */
    protected $Areas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Areas',
        'app.Estados',
        'app.AreasTipoEpps',
        'app.Entradas',
        'app.Programaciones',
        'app.Registros',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Areas') ? [] : ['className' => AreasTable::class];
        $this->Areas = $this->getTableLocator()->get('Areas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Areas);

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
