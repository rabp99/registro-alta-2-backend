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
        $usersTable = $this->table('users');

        $hasher = new DefaultPasswordHasher();

        $userData = [
            'username' => "70801887",
            'password' => $hasher->hash('70801887'),
            'full_name' => 'BOCANEGRA PALACIOS ROBERTO ANDRÉ',
            'role' => "Administrador",
            'status' => true
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
