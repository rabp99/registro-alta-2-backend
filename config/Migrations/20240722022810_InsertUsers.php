<?php

declare(strict_types=1);

use Migrations\AbstractMigration;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;

class InsertUsers extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        // Obtén la tabla que deseas modificar
        $estadosTable = TableRegistry::getTableLocator()->get('estados');

        // Realiza la consulta y actualización de datos
        $estado = $estadosTable->find()
            ->where(['descripcion' => 'Activo'])
            ->first();

        $usersTable = $this->table('users');

        $hasher = new DefaultPasswordHasher();

        $userData = [
            'username' => "70801887",
            'password' => $hasher->hash('70801887'),
            'nombre_completo' => 'BOCANEGRA PALACIOS ROBERTO ANDRÉ',
            'rol' => "Administrador",
            'estado_id' => $estado->id,
        ];

        $usersTable->insert($userData)->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM users');
    }
}
