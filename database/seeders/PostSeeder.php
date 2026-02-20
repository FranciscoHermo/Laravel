<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::truncate();

        for ($i=0; $i < 30; $i++) { 
            $c = Category::inRandomOrder()->first();

            $title= Str::random(20);

            Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias doloribus nam illo voluptatem earum eum iusto ullam atque numquam corrupti maxime saepe ut vel eos, unde dignissimos minus tempore dolorum?</p>",
                'category_id' => $c->id,
                'description' => "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias doloribus nam illo voluptatem earum </p>",
                'posted' => 'yes'
            ]);
        }
    }
}
