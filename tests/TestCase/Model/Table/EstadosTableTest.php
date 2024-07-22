<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstadosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstadosTable Test Case
 */
class EstadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstadosTable
     */
    protected $Estados;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Estados',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Estados') ? [] : ['className' => EstadosTable::class];
        $this->Estados = $this->getTableLocator()->get('Estados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Estados);

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
