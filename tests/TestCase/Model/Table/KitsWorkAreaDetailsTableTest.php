<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\KitsWorkAreaDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\KitsWorkAreaDetailsTable Test Case
 */
class KitsWorkAreaDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\KitsWorkAreaDetailsTable
     */
    protected $KitsWorkAreaDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.KitsWorkAreaDetails',
        'app.Kits',
        'app.WorkAreaDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('KitsWorkAreaDetails') ? [] : ['className' => KitsWorkAreaDetailsTable::class];
        $this->KitsWorkAreaDetails = $this->getTableLocator()->get('KitsWorkAreaDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->KitsWorkAreaDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\KitsWorkAreaDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\KitsWorkAreaDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
