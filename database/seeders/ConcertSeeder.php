<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Concert;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConcertSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first(); 

        if (!$admin) {
            $this->command->info('User dengan role "admin" tidak ditemukan, ConcertSeeder dilewati.');
            return;
        }
        
        $destinationPath = 'public/concert-images';
        Storage::deleteDirectory($destinationPath);
        Storage::makeDirectory($destinationPath);

        $concerts = [
            [
                'name' => 'Soeka Music Festival',
                'description' => 'Soeka Music Festival adalah festival musik tahunan yang diselenggarakan di De Tjolomadoe, Karanganyar, Jawa Tengah. Festival ini bertujuan untuk menghadirkan pengalaman musik yang tak terlupakan bagi para pecinta musik dengan menampilkan berbagai genre musik, mulai dari pop, rock, hingga dangdut dan elektronik (DJ). Festival ini menawarkan penampilan dari artis-artis ternama, termasuk band-band papan atas, dan berbagai kejutan yang dirancang untuk memanjakan penonton.',
                'venue' => 'De Tjolomadoe, Solo',
                'start_date' => '2025-11-15 20:00:00',
                'end_date' => '2025-11-15 23:00:00',
                'price' => 250000,
                'quota' => 500,
                'image_filename' => 'konser1.webp',
                'status' => 'active',
            ],
            [
                'name' => 'Projek-D Vol.1',
                'description' => 'Projek D Vol 1 adalah sebuah festival musik multi-genre yang diselenggarakan oleh Dyandra Promosindo. Festival ini bertujuan untuk menghadirkan pengalaman musik yang beragam dan dapat dinikmati oleh berbagai kalangan.',
                'venue' => 'De Tjolomadoe, Solo',
                'start_date' => '2026-02-10 19:30:00',
                'end_date' => '2026-02-10 22:30:00',
                'price' => 150000,
                'quota' => 500,
                'image_filename' => 'konser2.jpg',
                'status' => 'active',
            ],
            [
                'name' => 'Konser X.03',
                'description' => 'Konser X.03 adalah konser yang menjadi edisi ketiga dari Konser X. Acara ini menampilkan tiga bintang besar dalam industri musik Tanah Air, yaitu Denny Caknan, NDX AKA, dan Aftershine. Konser ini dikenal dengan atmosfer penuh semangat dan interaksi langsung dengan penonton.',
                'venue' => 'Lapangan Arhanud, Serpong Tangsel',
                'start_date' => '2025-12-20 20:00:00',
                'end_date' => '2025-12-20 23:00:00',
                'price' => 150000,
                'quota' => 300,
                'image_filename' => 'konser3.webp',
                'status' => 'active',
            ],
            [
                'name' => 'Swifties Karaoke Party',
                'description' => '"Swifties Karaoke Party" adalah acara karaoke yang fokus pada lagu-lagu Taylor Swift dan seringkali diselenggarakan oleh komunitas penggemar Taylor Swift (Swifties). Acara ini menyediakan wadah bagi para penggemar untuk bernyanyi bersama, merasakan kebersamaan, dan mungkin juga berbagi pengalaman galau atau emosi melalui lagu-lagu Taylor Swift.',
                'venue' => 'Downtown Seturan, Yogyakarta',
                'start_date' => '2025-10-05 20:00:00',
                'end_date' => '2025-10-05 23:00:00',
                'price' => 375000,
                'quota' => 300,
                'image_filename' => 'konser4.jpg',
                'status' => 'active',
            ],
        ];

        foreach ($concerts as $concertData) {
            Concert::create([
                'admin_id' => $admin->id,
                'name' => $concertData['name'],
                'description' => $concertData['description'],
                'venue' => $concertData['venue'],
                'start_date' => $concertData['start_date'],
                'end_date' => $concertData['end_date'],
                'price' => $concertData['price'],
                'quota' => $concertData['quota'],
                'status' => $concertData['status'],
                // Kita hanya menyimpan path relatif dari dalam folder public
                'image' => 'images/concerts/' . $concertData['image_filename'],
            ]);
        }
    }
}