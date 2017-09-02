<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'tester@tanyadev.com',
            'password' => bcrypt('tester'),
        ]);

        DB::table('tipe_novel')->insert([
            'nama_tipe' => 'Web Novel'
        ]);

        DB::table('tipe_novel')->insert([
            'nama_tipe' => 'Light Novel'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Romance'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Comedy'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Action'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Adult'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Adventure'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Drama'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Ecchi'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Fantasy'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Gender Bender'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Harem'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Historical'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Horror'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Josei'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Lolicon'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Martial Arts'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Mature'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Mecha'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Comedy'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Mystery'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Psychological'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Slice of Life'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'School Life'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Sci-fi'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Seinen'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shotacon'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shoujo'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shoujo Ai'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shounen'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shounen Ai'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Smut'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Sports'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Supernatural'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Tragedy'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Wuxia'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Xianxia'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Xuanhan'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Yaoi'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Yuri'
        ]);
    }
}
