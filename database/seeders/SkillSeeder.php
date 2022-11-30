<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = $this->getSkills();
        foreach ($skills as $skill)
            Skill::updateOrCreate([
                'skills' => $skill
            ]);
    }

    private function getSkills()
    {
        return [
            'js', 'php', 'html', 'css'
        ];

    }
}
