<?php

use App\Models\Auth\Settings;
use Illuminate\Database\Seeder;

/**
 * Class SettingsTableSeeder.
 */
class SettingsTableSeeder extends Seeder
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
        Settings::create([
            'code'        => 'enroller_income',
            'name'        => 'Enroller Commission',
            'desc'        => 'Commission amount to be gethered from new created downline by you.',
            'type'        => 'commission',
            'value'       => 800,
            'order'       => 1,
        ]);
        
        Settings::create([
            'code'        => 'downline_income',
            'name'        => 'Downline Commission',
            'desc'        => 'Commission amount to be gethered from new created downline by other.',
            'type'        => 'commission',
            'value'       => 50,
            'order'       => 2,
        ]);

        $this->enableForeignKeys();
    }
}
