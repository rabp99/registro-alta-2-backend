<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SolicitudesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SolicitudesTable Test Case
 */
class SolicitudesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SolicitudesTable
     */
    protected $Solicitudes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Solicitudes',
        'app.Programaciones',
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
        $config = $this->getTableLocator()->exists('Solicitudes') ? [] : ['className' => SolicitudesTable::class];
        $this->Solicitudes = $this->getTableLocator()->get('Solicitudes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Solicitudes);

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
