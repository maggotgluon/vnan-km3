<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Ruttaphong Worachartudomphong',
        //     'email' => 'ruttaphong.w@vananava.com',
        //     'staff_id' => 'VN433',
        //     'department'=>'Information Technology',
        //     'department_head'=> '1',
        //     'position'=>'Senior Developer',
        //     'user_level'=>'0'
        // ]);
        // \App\Models\User::factory(10)->create();

        $csvFile = fopen(base_path("database/data/users.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                \App\Models\User::factory()->create([
                    'staff_id'=> $data['1'],
                    'name' => $data['2'],
                    'department'=> $data['3'],
                    'department_head'=> $data['4'],
                    'position'=> $data['5'],
                    'user_level'=> $data['6'],
                    'status'=> 1,
                    'email' => $data['8'],
                    'password' => $data['10']??'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);


        \App\Models\UserPermission::create([
            'user_id'=>103,
            'permissions_type'=>'role',
            'parmission_name'=>'admin',
            'allowance'=>1
        ]);
    }
}
