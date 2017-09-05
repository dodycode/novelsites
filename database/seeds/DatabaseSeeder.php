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
            'nama_tipe' => 'Web Novel',
            'slug' => 'web-novel'
        ]);

        DB::table('tipe_novel')->insert([
            'nama_tipe' => 'Light Novel',
            'slug' => 'light-novel'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Romance',
            'slug' => 'romance'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Comedy',
            'slug' => 'comedy'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Action',
            'slug' => 'action'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Adult',
            'slug' => 'adult'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Adventure',
            'slug' => 'adventure'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Drama',
            'slug' => 'drama'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Ecchi',
            'slug' => 'ecchi'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Fantasy',
            'slug' => 'fantasy'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Gender Bender',
            'slug' => 'gender-bender'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Harem',
            'slug' => 'harem'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Historical',
            'slug' => 'historical'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Horror',
            'slug' => 'horror'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Josei',
            'slug' => 'josei'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Lolicon',
            'slug' => 'lolicon'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Martial Arts',
            'slug' => 'martial-arts'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Mature',
            'slug' => 'mature'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Mecha',
            'slug' => 'mecha'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Comedy',
            'slug' => 'comedy'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Mystery',
            'slug' => 'mystery'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Psychological',
            'slug' => 'psychological'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Slice of Life',
            'slug' => 'slice-of-life'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'School Life',
            'slug' => 'school-life'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Sci-fi',
            'slug' => 'sci-fi'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Seinen',
            'slug' => 'seinen'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shotacon',
            'slug' => 'shotacon'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shoujo',
            'slug' => 'shoujo'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shoujo Ai',
            'slug' => 'shoujo-ai'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shounen',
            'slug' => 'shounen'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Shounen Ai',
            'slug' => 'shounen-ai'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Smut',
            'slug' => 'smut'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Sports',
            'slug' => 'sports'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Supernatural',
            'slug' => 'supernatural'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Tragedy',
            'slug' => 'tragedy'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Wuxia',
            'slug' => 'wuxia'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Xianxia',
            'slug' => 'xianxia'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Xuanhan',
            'slug' => 'xuanhan'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Yaoi',
            'slug' => 'yaoi'
        ]);

        DB::table('genres')->insert([
            'nama_genre' => 'Yuri',
            'slug' => 'yuri'
        ]);
    }
}
