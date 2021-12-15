<?php

namespace Database\Seeders;

use App\Models\Work;
use App\Models\Tag;
use App\Models\WorkTag;
use Illuminate\Database\Seeder;

class WorkTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $works = Work::all();

        foreach ($works as $work) {
            $tags_id = Tag::inRandomOrder()->limit(random_int(1, 10))->get('id');

            foreach ($tags_id as $tag_id) {
                $work_tag = new WorkTag();

                $work_tag->work_id = $work->id;
                $work_tag->tag_id = $tag_id->id;

                $work_tag->save();
            }
        }
    }
}
