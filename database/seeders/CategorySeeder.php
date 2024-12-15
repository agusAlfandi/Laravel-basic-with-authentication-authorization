<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('categories')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $categories = ['tutorial', 'hobby', 'fashion', 'traveling', 'bisnis'];

    foreach ($categories as $category) {
      Category::create(['name' => $category]);
    }
  }
}
