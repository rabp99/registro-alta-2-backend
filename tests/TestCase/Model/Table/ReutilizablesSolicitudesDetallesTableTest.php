<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReutilizablesSolicitudesDetallesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReutilizablesSolicitudesDetallesTable Test Case
 */
class ReutilizablesSolicitudesDetallesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReutilizablesSolicitudesDetallesTable
     */
    protected $ReutilizablesSolicitudesDetalles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ReutilizablesSolicitudesDetalles',
        'app.Solicitudes',
        'app.Reutilizables',
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
        $config = $this->getTableLocator()->exists('ReutilizablesSolicitudesDetalles') ? [] : ['className' => ReutilizablesSolicitudesDetallesTable::class];
        $this->ReutilizablesSolicitudesDetalles = $this->getTableLocator()->get('ReutilizablesSolicitudesDetalles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ReutilizablesSolicitudesDetalles);

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
