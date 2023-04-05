<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Htun Aung Hlaing',
            'email' => 'htun@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Min Khant Zaw',
            'email' => 'min@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Michael',
            'email' => 'michael@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Wai Yan Tun',
            'email' => 'wai@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Nyein Chan',
            'email' => 'nc@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Zin Min Htet',
            'email' => 'zin@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Mo Mo',
            'email' => 'momo@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Teacher Wah Wah',
            'email' => 'wah@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Teacher Phyu',
            'email' => 'phyu@kmd.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Teacher Htar',
            'email' => 'htar@kmd.com',
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'Teacher Moe',
            'email' => 'moe@kmd.com',            
        ]);
        \App\Models\User::factory()->create([
            'name' => 'QA Manager',
            'email' => 'qam@kmd.com',
            'isApproved' => true,
            'isQAM' => true,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@kmd.com',
            'isApproved' => true,
            'isAdmin' => true,
        ]);
        $this->command->info('Users seeding done');

        \App\Models\Department::create([
            'name' => 'EWSD',
        ]);
        \App\Models\Department::create([
            'name' => 'HCI',
        ]);
        \App\Models\Department::create([
            'name' => 'RM',
        ]);
        $this->command->info('Department seeding done');
        
        \App\Models\Category::create([
            'name' => 'Sport',
            'slug' => 'sport',
            'description' => 'sport',
        ]);
        \App\Models\Category::create([
            'name' => 'Education',
            'slug' => 'education',
            'description' => 'education',
        ]);
        \App\Models\Category::create([
            'name' => 'Exam',
            'slug' => 'exam',
            'description' => 'exam',
        ]);
        \App\Models\Category::create([
            'name' => 'Course Work',
            'slug' => 'coursework',
            'description' => 'Course work',
        ]);
        $this->command->info('Category seeding done');  
    }
}
