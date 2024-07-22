<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Cake\ORM\TableRegistry;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run() {
        $usersTable = TableRegistry::getTableLocator()->get('users');
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "19254177";
        $user->password = "19254177";
        $user->nombre_completo = utf8_decode("QUISPE RODRÍGUEZ, BENJAMIN DANILO");
        $user->rol = "Administrador";
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "41870794";
        $user->password = "41870794";
        $user->nombre_completo = utf8_decode("ÁVILA ULLOA, CÉSAR");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "70801887";
        $user->password = "70801887";
        $user->nombre_completo = utf8_decode("BOCANEGRA PALACIOS, ROBERTO ANDRÉ");
        $user->rol = utf8_decode("Vestidores");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "47104444";
        $user->password = "47104444";
        $user->nombre_completo = utf8_decode("VARGAS TUMBA, DINI LAWRANCE");
        $user->rol = utf8_decode("Lavandería");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        // Farmacia
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "43068305";
        $user->password = "43068305";
        $user->nombre_completo = utf8_decode("GOMEZ CASTRO, LIAM");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "41275219";
        $user->password = "41275219";
        $user->nombre_completo = utf8_decode("VARGAS CARUAPOMA, ENRIQUE");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "42991271";
        $user->password = "42991271";
        $user->nombre_completo = utf8_decode("MIRANDA NARRO, MARIA KARINA");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "46450395";
        $user->password = "46450395";
        $user->nombre_completo = utf8_decode("REQUENA MALDONADO, MIGUEL");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "45912204";
        $user->password = "45912204";
        $user->nombre_completo = utf8_decode("RUIZ WONG DE PAREDES, MABEL");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "18140108";
        $user->password = "18140108";
        $user->nombre_completo = utf8_decode("BALAREZO GONZALEZ, MARIA ELENA");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "48286334";
        $user->password = "48286334";
        $user->nombre_completo = utf8_decode("TRUJILLO RODRIGUEZ, ANA");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "41008490";
        $user->password = "41008490";
        $user->nombre_completo = utf8_decode("JUAREZ CHICOMA, JAQUELINE");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "40646475";
        $user->password = "40646475";
        $user->nombre_completo = utf8_decode("JIMENEZ CORDERO, JANETH");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "40181644";
        $user->password = "40181644";
        $user->nombre_completo = utf8_decode("QUEZADA VALLE, CATHERINE");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "18897398";
        $user->password = "18897398";
        $user->nombre_completo = utf8_decode("NUREÑA LEON, LINDA");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "18893066";
        $user->password = "18893066";
        $user->nombre_completo = utf8_decode("SANCHEZ ALVA, RAQUEL");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "41755530";
        $user->password = "41755530";
        $user->nombre_completo = utf8_decode("LOPEZ BARBOZA, TONY");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "46164981";
        $user->password = "46164981";
        $user->nombre_completo = utf8_decode("PEREZ SARMIENTO, MARIO");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "40475650";
        $user->password = "40475650";
        $user->nombre_completo = utf8_decode("AMAYA ALCANTARA, KATHERIN");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        // Vestidores        
        $user = $usersTable->newEmptyEntity();
        $user->username = "41089612";
        $user->password = "41089612";
        $user->nombre_completo = utf8_decode("ESPINOLA RODRIGUEZ, CARMEN PETRONILA");
        $user->rol = utf8_decode("Vestidores");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "18144309";
        $user->password = "18144309";
        $user->nombre_completo = utf8_decode("LOPEZ VILLANUEVA, NANCY");
        $user->rol = utf8_decode("Vestidores");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "43974133";
        $user->password = "43974133";
        $user->nombre_completo = utf8_decode("MEZA JIMENEZ, EVELIN");
        $user->rol = utf8_decode("Vestidores");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "44924671";
        $user->password = "44924671";
        $user->nombre_completo = utf8_decode("OSORIO ROJAS, ANALI");
        $user->rol = utf8_decode("Vestidores");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "42095512";
        $user->password = "42095512";
        $user->nombre_completo = utf8_decode("PEREZ ORTEGA, VICTOR");
        $user->rol = utf8_decode("Vestidores");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "19560461";
        $user->password = "19560461";
        $user->nombre_completo = utf8_decode("YUPANQUI ARAUJO, YAMILE");
        $user->rol = utf8_decode("Vestidores");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "45265506";
        $user->password = "45265506";
        $user->nombre_completo = utf8_decode("LEDESMA TRUJILLO, GIOVANNA ADRIANA");
        $user->rol = utf8_decode("Vestidores");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        // Lavanderia
        $user = $usersTable->newEmptyEntity();
        $user->username = "lavanderia";
        $user->password = "lavanderia";
        $user->nombre_completo = utf8_decode("LAVANDERIA");
        $user->rol = utf8_decode("Lavandería");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        // Administrador
        $user = $usersTable->newEmptyEntity();
        $user->username = "40900935";
        $user->password = "40900935";
        $user->nombre_completo = utf8_decode("ESCATE GARCIA, EGO EDUARDO");
        $user->rol = utf8_decode("Administrador");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        // Médico Ocupacional
        $user = $usersTable->newEmptyEntity();
        $user->username = "70296473";
        $user->password = "70296473";
        $user->nombre_completo = utf8_decode("ROSALES OLIVARI, STEFHANIE JACQUELINE");
        $user->rol = utf8_decode("Médico Ocupacional");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        // Jefe de Servicio
        $user = $usersTable->newEmptyEntity();
        $user->username = "32939794";
        $user->password = "32939794";
        $user->nombre_completo = utf8_decode("TAPIA UGAZ, DORILA EUGENIA");
        $user->rol = utf8_decode("Jefe de Servicio");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        // Farmacia
        $user = $usersTable->newEmptyEntity();
        $user->username = "41534365";
        $user->password = "41534365";
        $user->nombre_completo = utf8_decode("ALTAMIRANO SARMIENTO, DAN ORLANDO");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "44816788";
        $user->password = "44816788";
        $user->nombre_completo = utf8_decode("VÁSQUEZ PERALTA, MELIZA JACQUELINE");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "40439472";
        $user->password = "40439472";
        $user->nombre_completo = utf8_decode("SÁNCHEZ CABRERA, CLARA ZARAGOZA");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
        
        $user = $usersTable->newEmptyEntity();
        $user->username = "44380552";
        $user->password = "44380552";
        $user->nombre_completo = utf8_decode("AYALA CARHUARICRA, MARIBEL FELICITA");
        $user->rol = utf8_decode("Farmacia");
        $user->estado_id = 1;
        $usersTable->save($user);
    }
}