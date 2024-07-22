<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GruposOcupacionalesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GruposOcupacionalesTable Test Case
 */
class GruposOcupacionalesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GruposOcupacionalesTable
     */
    protected $GruposOcupacionales;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GruposOcupacionales',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GruposOcupacionales') ? [] : ['className' => GruposOcupacionalesTable::class];
        $this->GruposOcupacionales = $this->getTableLocator()->get('GruposOcupacionales', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GruposOcupacionales);

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
