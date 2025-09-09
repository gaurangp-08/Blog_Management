<?php

namespace Database\Seeders;

use App\Models\{Blog, User};
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id')->toArray();

        $blogs = [
            ['title' => 'Getting Started with Laravel', 'description' => 'Laravel is a powerful PHP framework that makes web development enjoyable and creative.'],
            ['title' => 'Top 5 Travel Destinations in Europe', 'description' => 'Explore the most beautiful and adventurous travel destinations across Europe.'],
            ['title' => 'Understanding API Development', 'description' => 'APIs are the backbone of modern web applications. Learn how to build robust APIs.'],
            ['title' => 'Mastering Photography Basics', 'description' => 'Learn the fundamentals of photography and improve your photography skills quickly.'],
            ['title' => 'Healthy Eating Habits', 'description' => 'Discover how to maintain a balanced diet and lead a healthier lifestyle.'],
            ['title' => 'The Future of Artificial Intelligence', 'description' => 'AI is transforming industries. Here’s what you need to know about its future.'],
            ['title' => 'Top Programming Languages in 2025', 'description' => 'Stay ahead of the curve with the most in-demand programming languages.'],
            ['title' => 'Remote Work Productivity Tips', 'description' => 'Boost your productivity while working from home with these practical tips.'],
            ['title' => 'Best Practices for Cybersecurity', 'description' => 'Learn how to secure your applications and protect user data effectively.'],
            ['title' => 'Guide to Personal Finance Management', 'description' => 'Simple strategies to save, invest, and grow your money.'],
        ];

        foreach ($blogs as $blog) {
            Blog::create([
                'title'       => $blog['title'],
                'description' => $blog['description'],
                'user_id'     => $users[array_rand($users)],
                'likes_count' => rand(0, 50),
                //random image 
                'image'       => "https://picsum.photos/seed/" . uniqid() . "/640/480", 
            ]);
        }
    }
}
