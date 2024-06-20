<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Settings::$settingsNames as $key => $value) {
            Settings::firstOrCreate([
                'id' => $key,
                'name' => $value,
                'value' => Settings::$settingsValues[$key],
            ]);
        }
    }
}
