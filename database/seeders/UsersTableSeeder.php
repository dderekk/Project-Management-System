<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //-----  Teacher  -----
        DB::table('users')->insert([
            'name'=>'AAAA',
            'email' => 'aaaa@gmail.com',
            'password'=> bcrypt('123'),
            'type' => 'Teacher'
        ]);

        //----- Initial 6 Industry Partner  -----
        DB::table('users')->insert([
            'name'=>'Alice',
            'email' => 'Alice1@gamil.com',
            'password'=> bcrypt('alice123'),
            'type' => 'Industry Partner',
            'is_approved'=>1,
            'organization'=>'Carson',
        ]);
        DB::table('users')->insert([
            'name'=>'Bobie',
            'email' => 'Bob1@gamil.com',
            'password'=> bcrypt('bob111'),
            'type' => 'Industry Partner',
            'is_approved'=>1,
            'organization'=>'Carson',
        ]);
        DB::table('users')->insert([
            'name'=>'Catherine',
            'email' => 'Catherine@gamil.com',
            'password'=> bcrypt('Catherine1'),
            'type' => 'Industry Partner',
            'is_approved'=>1,
            'organization'=>'Toyar',
        ]);
        DB::table('users')->insert([
            'name'=>'David',
            'email' => 'David@gamil.com',
            'password'=> bcrypt('David1'),
            'type' => 'Industry Partner',
            'is_approved'=>1,
            'organization'=>'Toyar',
        ]);
        DB::table('users')->insert([
            'name'=>'Emily',
            'email' => 'Emily@gamil.com',
            'password'=> bcrypt('Emily1'),
            'type' => 'Industry Partner',
            'is_approved'=>1,
            'organization'=>'milanpavilion',
        ]);
        DB::table('users')->insert([
            'name'=>'Frank',
            'email' => 'Frank@gamil.com',
            'password'=> bcrypt('Frank1'),
            'type' => 'Industry Partner',
            'is_approved'=>1,
            'organization'=>'milanpavilion',
        ]);

        //----- Initial 6 Students  -----
        DB::table('users')->insert([
            'name'=>'Grace',
            'email' => 'Grace@gamil.com',
            'password'=> bcrypt('Grace1'),
            'type' => 'Student',
        ]);
        DB::table('users')->insert([
            'name'=>'Henry',
            'email' => ' Henry@gamil.com',
            'password'=> bcrypt('Henry1'),
            'type' => 'Student',
        ]);
        DB::table('users')->insert([
            'name'=>'Isabella',
            'email' => 'Isabella@gamil.com',
            'password'=> bcrypt('Isabella1'),
            'type' => 'Student',
        ]);
        DB::table('users')->insert([
            'name'=>'James',
            'email' => 'James@gamil.com',
            'password'=> bcrypt('James1'),
            'type' => 'Student',
        ]);
        DB::table('users')->insert([
            'name'=>'Katherine',
            'email' => 'Katherine@gamil.com',
            'password'=> bcrypt('Katherine1'),
            'type' => 'Student',
        ]);
        DB::table('users')->insert([
            'name'=>'Liama',
            'email' => 'Liam@gamil.com',
            'password'=> bcrypt('Liam1'),
            'type' => 'Student',
        ]);

        //----- Additional 20 Students -----
        $students = [
            'Mia', 'Joseph', 'Margaret', 'Charles', 'Jessica', 'Thomas', 'Sarah', 'Daniel',
            'Karen', 'Matthew', 'Nancy', 'Anthony', 'Lisa', 'Mark', 'Sandra', 'Paul',
            'Ashley', 'Steven', 'Kimberly', 'Andrew'
        ];

        foreach ($students as $student) {
            DB::table('users')->insert([
                'name' => $student,
                'email' => strtolower($student) . '@gmail.com',
                'password' => bcrypt($student . '123'),
                'type' => 'Student',
            ]);
        }
        
        //----- Additional 10 Industry Partner -----
        $industryPartners = [
            ['name' => 'John', 'organization' => 'TechCorp'],
            ['name' => 'Jane', 'organization' => 'TechCorp'],
            ['name' => 'Robert', 'organization' => 'WebSolutions'],
            ['name' => 'Linda', 'organization' => 'WebSolutions'],
            ['name' => 'Michael', 'organization' => 'DataWise'],
            ['name' => 'Barbara', 'organization' => 'DataWise'],
            ['name' => 'William', 'organization' => 'NetTech'],
            ['name' => 'Elizabeth', 'organization' => 'NetTech'],
            ['name' => 'Richard', 'organization' => 'InfoTech'],
            ['name' => 'Susan', 'organization' => 'InfoTech'],
        ];

        foreach ($industryPartners as $partner) {
            DB::table('users')->insert([
                'name' => $partner['name'],
                'email' => strtolower($partner['name']) . '@gmail.com',
                'password' => bcrypt($partner['name'] . '123'),
                'type' => 'Industry Partner',
                'is_approved' => rand(0, 1), // Randomly approve some partners
                'organization' => $partner['organization'],
            ]);
        }

    }
}
