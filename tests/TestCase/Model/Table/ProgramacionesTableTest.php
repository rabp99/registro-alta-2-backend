<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacionesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacionesTable Test Case
 */
class ProgramacionesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacionesTable
     */
    protected $Programaciones;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Programaciones',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Programaciones') ? [] : ['className' => ProgramacionesTable::class];
        $this->Programaciones = $this->getTableLocator()->get('Programaciones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Programaciones);

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
