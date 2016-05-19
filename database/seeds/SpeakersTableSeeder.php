<?php
/**
 * @author       Lemberg Solution LAMP Team
 */

use Illuminate\Database\Seeder;


class SpeakersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Speaker::class, 50)->create();
    }
}