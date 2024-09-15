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
            'username' => "41870794",
            'password' => $hasher->hash('41870794'),
            'full_name' => 'ÁVILA ULLOA, CÉSAR',
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
