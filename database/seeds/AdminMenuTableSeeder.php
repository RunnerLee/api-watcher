<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 7,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 8,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 9,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 10,
                'title' => 'Permission',
                'icon' => 'fa-user',
                'uri' => 'auth/permissions',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 11,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 12,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 13,
                'title' => 'Helpers',
                'icon' => 'fa-gears',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 8,
                'order' => 14,
                'title' => 'Scaffold',
                'icon' => 'fa-keyboard-o',
                'uri' => 'helpers/scaffold',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 8,
                'order' => 15,
                'title' => 'Database terminal',
                'icon' => 'fa-database',
                'uri' => 'helpers/terminal/database',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 8,
                'order' => 16,
                'title' => 'Laravel artisan',
                'icon' => 'fa-terminal',
                'uri' => 'helpers/terminal/artisan',
                'created_at' => NULL,
                'updated_at' => '2017-08-11 03:05:55',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'API Groups',
                'icon' => 'fa-align-left',
                'uri' => 'api_groups',
                'created_at' => '2017-08-11 02:32:23',
                'updated_at' => '2017-08-11 06:21:57',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 0,
                'order' => 3,
                'title' => 'Apis',
                'icon' => 'fa-align-left',
                'uri' => 'apis',
                'created_at' => '2017-08-11 02:32:31',
                'updated_at' => '2017-08-11 06:21:52',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 0,
                'order' => 4,
                'title' => 'Fakers',
                'icon' => 'fa-align-left',
                'uri' => 'fakers',
                'created_at' => '2017-08-11 02:32:40',
                'updated_at' => '2017-08-11 06:21:23',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 0,
                'order' => 5,
                'title' => 'Schedule Rules',
                'icon' => 'fa-align-left',
                'uri' => 'schedule_rules',
                'created_at' => '2017-08-11 02:34:03',
                'updated_at' => '2017-08-11 06:21:38',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 0,
                'order' => 6,
                'title' => 'Missions',
                'icon' => 'fa-align-left',
                'uri' => 'missions',
                'created_at' => '2017-08-11 03:05:50',
                'updated_at' => '2017-08-11 06:22:05',
            ),
        ));
        
        
    }
}