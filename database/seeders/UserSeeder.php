<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Teguh Budi Laksono',
                'username' => 'teguhbudi',
                'email'    => 'teguh@example.com',
                'gender'   => 'Male',
                'phone_number'    => '6289627113090',
                'bio'      => 'Full-stack developer dengan passion di bidang web & mobile. Suka ngulik teknologi baru dan bikin project streaming.',
                'skills'        => ['Web Development', 'Backend Development', 'Mobile Development'],
                'needed_skills' => ['UI/UX Design', 'Motion Graphics'],
            ],
            [
                'name'     => 'Rina Kusumawati',
                'username' => 'rinakusuma',
                'email'    => 'rina@example.com',
                'gender'   => 'Female',
                'phone_number'    => '6282233445566',
                'bio'      => 'UI/UX designer yang obsessed sama clean design dan user experience yang smooth. Open buat collab project digital product.',
                'skills'        => ['UI/UX Design', 'Graphic Design', 'Illustration'],
                'needed_skills' => ['Frontend Development', 'Web Development'],
            ],
            [
                'name'     => 'Dimas Arya Putra',
                'username' => 'dimasarya',
                'email'    => 'dimas@example.com',
                'gender'   => 'Male',
                'phone_number'    => '6285566778899',
                'bio'      => 'Content creator & copywriter. Spesialisasi di digital marketing dan storytelling untuk brand. Udah handle 20+ klien.',
                'skills'        => ['Content Writing', 'Copywriting', 'Digital Marketing'],
                'needed_skills' => ['Graphic Design', 'Video Editing'],
            ],
            [
                'name'     => 'Siti Nuraini',
                'username' => 'sitinur',
                'email'    => 'siti@example.com',
                'gender'   => 'Female',
                'phone_number'    => '6287788990011',
                'bio'      => 'Fotografer dan videografer freelance. Suka dokumentasi event, produk, dan portrait. Editing pakai Premiere & Lightroom.',
                'skills'        => ['Photography', 'Video Editing'],
                'needed_skills' => ['Digital Marketing', 'Copywriting'],
            ],
            [
                'name'     => 'Budi Santoso',
                'username' => 'budisant',
                'email'    => 'budi@example.com',
                'gender'   => 'Male',
                'phone_number'    => '6289911223344',
                'bio'      => 'Data analyst dengan background machine learning. Senang ngulik dataset dan bikin visualisasi data yang informatif.',
                'skills'        => ['Data Analysis', 'Machine Learning'],
                'needed_skills' => ['Web Development', 'UI/UX Design'],
            ],
            [
                'name'     => 'Anisa Fitria',
                'username' => 'anisafit',
                'email'    => 'anisa@example.com',
                'gender'   => 'Female',
                'phone_number'    => '6281122334455',
                'bio'      => 'Motion graphics designer, biasa kerja bareng agency kreatif. Spesialis animasi 2D dan explainer video.',
                'skills'        => ['Motion Graphics', 'Illustration', 'Graphic Design'],
                'needed_skills' => ['Copywriting', 'Digital Marketing'],
            ],
            [
                'name'     => 'Reza Mahendra',
                'username' => 'rezamahendra',
                'email'    => 'reza@example.com',
                'gender'   => 'Male',
                'phone_number'    => '6283344556677',
                'bio'      => 'Backend engineer, fokus di sistem scalable dan arsitektur microservice. Main stack Go & Node.js. Open buat side project.',
                'skills'        => ['Backend Development', 'DevOps', 'Cybersecurity'],
                'needed_skills' => ['Frontend Development', 'UI/UX Design'],
            ],
            [
                'name'     => 'Dewi Puspita',
                'username' => 'dewipus',
                'email'    => 'dewi@example.com',
                'gender'   => 'Female',
                'phone_number'    => '6284455667788',
                'bio'      => 'SEO specialist dan digital marketer. Bantu brand naik ranking Google dan grow organic traffic. Certified Google Analytics.',
                'skills'        => ['SEO', 'Digital Marketing', 'Content Writing'],
                'needed_skills' => ['Web Development', 'Graphic Design'],
            ],
            [
                'name'     => 'Fajar Nugroho',
                'username' => 'fajarnug',
                'email'    => 'fajar@example.com',
                'gender'   => 'Male',
                'phone_number'    => '6286677889900',
                'bio'      => 'Frontend developer yang jatuh cinta sama React & Vue. Perfeksionis soal pixel dan animasi. Suka bikin UI yang terasa hidup.',
                'skills'        => ['Frontend Development', 'Web Development', 'UI/UX Design'],
                'needed_skills' => ['Backend Development', 'DevOps'],
            ],
            [
                'name'     => 'Maya Andriani',
                'username' => 'mayaandri',
                'email'    => 'maya@example.com',
                'gender'   => 'Female',
                'phone_number'    => '6288899001122',
                'bio'      => 'Illustrator dan komikus indie. Udah publish 3 komik digital dan kolaborasi sama beberapa brand lokal untuk karakter ilustrasi.',
                'skills'        => ['Illustration', 'Graphic Design'],
                'needed_skills' => ['Web Development', 'Digital Marketing'],
            ],
            [
                'name'     => 'Hendra Wijaya',
                'username' => 'hendrawjy',
                'email'    => 'hendra@example.com',
                'gender'   => 'Male',
                'phone_number'    => '6281999000111',
                'bio'      => 'DevOps engineer, spesialis CI/CD dan cloud infrastructure di AWS & GCP. Suka ngoprek server dan automation script.',
                'skills'        => ['DevOps', 'Cybersecurity', 'Backend Development'],
                'needed_skills' => ['Mobile Development', 'UI/UX Design'],
            ],
            [
                'name'     => 'Lestari Wulandari',
                'username' => 'lestariwulan',
                'email'    => 'lestari@example.com',
                'gender'   => 'Female',
                'phone_number'    => '6282000111222',
                'bio'      => 'Mobile developer (React Native & Flutter). Fokus di performa dan pengalaman user di aplikasi konsumer. Hobi review apps.',
                'skills'        => ['Mobile Development', 'Frontend Development'],
                'needed_skills' => ['UI/UX Design', 'Backend Development'],
            ],
        ];

        foreach ($users as $data) {
            $skillNames       = $data['skills'];
            $neededSkillNames = $data['needed_skills'];
            unset($data['skills'], $data['needed_skills']);

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'          => Hash::make('password'),
                ])
            );

            $skillIds  = Skill::whereIn('name', $skillNames)->pluck('id')->toArray();
            $neededIds = Skill::whereIn('name', $neededSkillNames)->pluck('id')->toArray();

            $user->skills()->sync($skillIds);
            $user->neededSkills()->sync($neededIds);
        }
    }
}
