<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TagTarget;

class TagTargetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['IT', 'WEB', 'GAME'];
        
        foreach($arr as $value){
            $tagTarget = new TagTarget();
            $tagTarget->target_name = $value;
            $tagTarget->save();
        }
    }
}
