<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fees')->delete();
        $program = Program::where('code', 'BSIT')->first();
        $categories = Category::get('id');
        $fees = [];

        foreach ($categories as $category) {
            $fees[] = [ 'program_id' => $program->id, 'category_id' => $category->id, 'price' => round(rand(100000, 300000)),
                'description' => 'N/A', 'created_at' => now(), 'updated_at' => now()];
        }

        DB::table('fees')->insert($fees);
    }
}
