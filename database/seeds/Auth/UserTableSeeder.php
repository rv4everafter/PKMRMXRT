<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Add the master administrator, user id of 1
        User::create([
            'first_name'        => 'Super',
            'last_name'         => 'Admin',
            'email'             => 'superadmin@tnbonce.com',
            'password'          => bcrypt('super@TNBOnce'),
            'active'             => 1,
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::create([
            'first_name'        => 'Backend',
            'last_name'         => 'User',
            'email'             => 'admin@tnbonce.com',
            'password'          => bcrypt('user@TNBOnce'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::create([
            'first_name'        => 'Default',
            'last_name'         => 'User',          
            'email'             => 'user@tnbonce.com',
            'enroller_id'       => 'eroller1',
            'sponsor_id'        => 'sponsor1',
            'password'          => bcrypt('user@TNBOnce'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        $this->enableForeignKeys();
    }
}
