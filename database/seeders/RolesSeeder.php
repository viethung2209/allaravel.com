<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author = Role::create([
            'name' => 'Phóng viên',
            'slug' => 'author',
            'permissions' => [
                'posts.create' => true,
            ]
        ]);
        $editor = Role::create([
            'name' => 'Biên tập viên',
            'slug' => 'editor',
            'permissions' => [
                'posts.update' => true,
                'posts.publish' => true,
            ]
        ]);
    }
}
