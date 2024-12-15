<?php

namespace Database\Seeders;

use App\Models\blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('blogs')->truncate();

    blog::factory()->count(30)->create();

    // DB::table('blogs')->insert([
    //     'title' => "Title 1",
    //     'description' => "Description 1",
    // ]);
  }
}
