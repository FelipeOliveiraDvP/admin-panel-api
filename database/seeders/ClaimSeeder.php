<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('claims')->insert([
            // Users
            [
                'identifier' => 'list:users',
                'name' => 'Listar usuários',
            ],
            [
                'identifier' => 'create:users',
                'name' => 'Criar usuários',
            ],
            [
                'identifier' => 'update:users',
                'name' => 'Atualizar usuários',
            ],
            [
                'identifier' => 'remove:users',
                'name' => 'Remover usuários',
            ],
            // Posts
            [
                'identifier' => 'list:posts',
                'name' => 'Listar artigos',
            ],
            [
                'identifier' => 'create:posts',
                'name' => 'Criar artigos',
            ],
            [
                'identifier' => 'update:posts',
                'name' => 'Atualizar artigos',
            ],
            [
                'identifier' => 'remove:posts',
                'name' => 'Remover artigos',
            ],
        ]);
    }
}
