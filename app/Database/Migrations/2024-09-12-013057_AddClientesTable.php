<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientsTable extends Migration
{
    public function up()
    {
        // Criar a tabela clients
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'name'        => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'cnpj'        => [
                'type'       => 'VARCHAR',
                'constraint' => '14', // O CNPJ tem 14 caracteres
                'unique'     => true, // CNPJ deve ser único
            ],
            'logo'        => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Logo pode ser opcional
            ],
            'created_at'  => [
                'type'      => 'DATETIME',
                'null'      => true,
            ],
            'updated_at'  => [
                'type'      => 'DATETIME',
                'null'      => true,
            ],
        ]);
        $this->forge->addKey('id', true); // Define a chave primária
        $this->forge->createTable('clients'); // Cria a tabela
    }

    public function down()
    {
        // Remove a tabela clients se existir
        $this->forge->dropTable('clients');
    }
}
