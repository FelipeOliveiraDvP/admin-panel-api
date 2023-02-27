<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin role.
        $admin_role_id = DB::table('roles')->insertGetId([
            'name' => 'Administrador'
        ]);

        $admin_claims = DB::table('claims')->select('id')->get();

        foreach ($admin_claims as $claim) {
            DB::table('role_claims')->insert([
                'role_id' => $admin_role_id,
                'claim_id' => $claim->id
            ]);
        }

        // Author role.
        $author_role_id = DB::table('roles')->insertGetId([
            'name' => 'Autor'
        ]);

        $author_claims = DB::table('claims')
            ->select('id')
            ->whereIn('identifier', ['create:posts', 'update:posts'])
            ->get();

        foreach ($author_claims as $claim) {
            DB::table('role_claims')->insert([
                'role_id' => $author_role_id,
                'claim_id' => $claim->id
            ]);
        }

        // Reader role.
        DB::table('roles')->insert([
            'name' => 'Leitor'
        ]);
    }
}
