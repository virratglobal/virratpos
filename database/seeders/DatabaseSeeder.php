<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Utility;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Run normally:            php artisan db:seed
     * With demo data:          SEED_DEMO_DATA=true php artisan db:seed
     *                          (on Windows PowerShell: $env:SEED_DEMO_DATA="true"; php artisan db:seed)
     *
     * @return void
     */
    public function run()
    {
        if(\Request::route() == null || \Request::route()->getName()!='LaravelUpdater::database')
        {
            $this->call(UsersTableSeeder::class);
            $this->call(PlansTableSeeder::class);
            $this->call(AiTemplateSeeder::class);
        }else{
            Utility::languagecreate();
            // Utility::defaultEmail();
        }
        Artisan::call('module:migrate LandingPage');
        Artisan::call('module:seed LandingPage');

        // Optional demo data — safe for local dev, do NOT run on production
        if (env('SEED_DEMO_DATA') === 'true') {
            $this->call(DemoDataSeeder::class);
        }
    }
}
