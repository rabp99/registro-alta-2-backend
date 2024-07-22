<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ColaboradoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ColaboradoresController Test Case
 *
 * @uses \App\Controller\ColaboradoresController
 */
class ColaboradoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Colaboradores',
        'app.Estados',
    ];
    
    
    /**
     * Test register method
     *
     * @return void
     */
    public function testGetEnabled(): void {
        $this->post('/api/colaboradores/get_enabled.json');
        $this->assertResponseCode(405);
        
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);
        $this->get('/api/colaboradores/get_enabled.json');
        $this->assertResponseCode(200);
        
        
    }
}
