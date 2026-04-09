<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'Web Development',
            'Mobile Development',
            'UI/UX Design',
            'Graphic Design',
            'Video Editing',
            'Content Writing',
            'SEO',
            'Digital Marketing',
            'Data Analysis',
            'Machine Learning',
            'Copywriting',
            'Photography',
            'Illustration',
            'Motion Graphics',
            'Backend Development',
            'Frontend Development',
            'DevOps',
            'Cybersecurity',
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['slug' => Str::slug($skill)],
                ['name' => $skill]
            );
        }
    }
}
