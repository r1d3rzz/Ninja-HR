<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!CompanySetting::exists()) {
            $setting = new CompanySetting;
            $setting->name = "Rider Tech";
            $setting->email = "ridertech@gmail.com";
            $setting->phone = "0931543084";
            $setting->address = "No(562) Rider Township, Yangon";
            $setting->office_start_time = "09:00:00";
            $setting->office_end_time = "18:00:00";
            $setting->break_start_time = "12:00:00";
            $setting->break_end_time = "13:00:00";
            $setting->save();
        }
    }
}
