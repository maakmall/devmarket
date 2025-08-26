<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all(['id']);
        $users = User::pluck('id');

        foreach($categories as $category) {
            Product::factory(10, [
                'category_id' => $category->id,
                'user_id' => $users->shuffle()->first(),
            ])->create();
        }
    }
}
