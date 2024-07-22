<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AreasTipoEppsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AreasTipoEppsTable Test Case
 */
class AreasTipoEppsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AreasTipoEppsTable
     */
    protected $AreasTipoEpps;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AreasTipoEpps',
        'app.Areas',
        'app.TiposEpps',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AreasTipoEpps') ? [] : ['className' => AreasTipoEppsTable::class];
        $this->AreasTipoEpps = $this->getTableLocator()->get('AreasTipoEpps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AreasTipoEpps);

        parent::tearDown();
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
