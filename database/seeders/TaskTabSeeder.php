<?php

namespace Database\Seeders;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1,3) as $num){
            DB::table('tasks')->insert([
                'folder_id'=> 1,
                'title' => "sample task {$num}",
                'status' => $num,
                'due_date'=> Carbon::now()->addDay($num),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
