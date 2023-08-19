<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator as Faker;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Http\Controllers\BaseController;
use App\Models\Image;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $baseController = new BaseController();

        $place = json_decode('{
            "Johor": [
                "Johor Bahru",
                "Tebrau",
                "Pasir Gudang",
                "Bukit Indah",
                "Skudai",
                "Kluang",
                "Batu Pahat",
                "Muar",
                "Ulu Tiram",
                "Senai",
                "Segamat",
                "Kulai",
                "Kota Tinggi",
                "Pontian Kechil",
                "Tangkak",
                "Bukit Bakri",
                "Yong Peng",
                "Pekan Nenas",
                "Labis",
                "Mersing",
                "Simpang Renggam",
                "Parit Raja",
                "Kelapa Sawit",
                "Buloh Kasap",
                "Chaah"
              ],
              "Kedah": [
                "Sungai Petani",
                "Alor Setar",
                "Kulim",
                "Jitra / Kubang Pasu",
                "Baling",
                "Pendang",
                "Langkawi",
                "Yan",
                "Sik",
                "Kuala Nerang",
                "Pokok Sena",
                "Bandar Baharu"
              ],
              "Kelantan": [
                "Kota Bharu",
                "Pangkal Kalong",
                "Tanah Merah",
                "Peringat",
                "Wakaf Baru",
                "Kadok",
                "Pasir Mas",
                "Gua Musang",
                "Kuala Krai",
                "Tumpat"
              ],
              "Melaka": [
                "Bandaraya Melaka",
                "Bukit Baru",
                "Ayer Keroh",
                "Klebang",
                "Masjid Tanah",
                "Sungai Udang",
                "Batu Berendam",
                "Alor Gajah",
                "Bukit Rambai",
                "Ayer Molek",
                "Bemban",
                "Kuala Sungai Baru",
                "Pulau Sebang",
                "Jasin"
              ],
              "Sembilan": [
                "Seremban",
                "Port Dickson",
                "Nilai",
                "Bahau",
                "Tampin",
                "Kuala Pilah"
              ],
              "Pahang": [
                "Kuantan",
                "Temerloh",
                "Bentong",
                "Mentakab",
                "Raub",
                "Jerantut",
                "Pekan",
                "Kuala Lipis",
                "Bandar Jengka",
                "Bukit Tinggi"
              ],
              "Perak": [
                "Ipoh",
                "Taiping",
                "Sitiawan",
                "Simpang Empat",
                "Teluk Intan",
                "Batu Gajah",
                "Lumut",
                "Kampung Koh",
                "Kuala Kangsar",
                "Sungai Siput Utara",
                "Tapah",
                "Bidor",
                "Parit Buntar",
                "Ayer Tawar",
                "Bagan Serai",
                "Tanjung Malim",
                "Lawan Kuda Baharu",
                "Pantai Remis",
                "Kampar"
              ],
              "Perlis": [
                "Kangar",
                "Kuala Perlis"
              ],
              "Pinang": [
                "Bukit Mertajam",
                "Georgetown",
                "Sungai Ara",
                "Gelugor",
                "Ayer Itam",
                "Butterworth",
                "Perai",
                "Nibong Tebal",
                "Permatang Kucing",
                "Tanjung Tokong",
                "Kepala Batas",
                "Tanjung Bungah",
                "Juru"
              ],
              "Sabah": [
                "Kota Kinabalu",
                "Sandakan",
                "Tawau",
                "Lahad Datu",
                "Keningau",
                "Putatan",
                "Donggongon",
                "Semporna",
                "Kudat",
                "Kunak",
                "Papar",
                "Ranau",
                "Beaufort",
                "Kinarut",
                "Kota Belud"
              ],
              "Sarawak": [
                "Kuching",
                "Miri",
                "Sibu",
                "Bintulu",
                "Limbang",
                "Sarikei",
                "Sri Aman",
                "Kapit",
                "Batu Delapan Bazaar",
                "Kota Samarahan"
              ],
              "Terengganu": [
                "Kuala Terengganu",
                "Chukai",
                "Dungun",
                "Kerteh",
                "Kuala Berang",
                "Marang",
                "Paka",
                "Jerteh"
              ],
              "Selangor": [
                "Subang Jaya",
                "Klang",
                "Ampang Jaya",
                "Shah Alam",
                "Petaling Jaya",
                "Cheras",
                "Kajang",
                "Selayang Baru",
                "Rawang",
                "Taman Greenwood",
                "Semenyih",
                "Banting",
                "Balakong",
                "Gombak Setia",
                "Kuala Selangor",
                "Serendah",
                "Bukit Beruntung",
                "Pengkalan Kundang",
                "Jenjarom",
                "Sungai Besar",
                "Batu Arang",
                "Tanjung Sepat",
                "Kuang",
                "Kuala Kubu Baharu",
                "Batang Berjuntai",
                "Bandar Baru Salak Tinggi",
                "Sekinchan",
                "Sabak",
                "Tanjung Karang",
                "Beranang",
                "Sungai Pelek",
                "Sepang"
              ],
              "Wilayah Persekutuan": [
                "Kuala Lumpur",
                "Labuan",
                "Putrajaya"
              ]
            }', true);

        foreach ($place as $stateName => $places) {
            $productCategory = [
                'uid'       => uniqid('UID'),
                'name'      => $stateName,
                'is_active' => rand(0, 1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $productCategoryModel = ProductCategory::create($productCategory);
            $image = Image::get('id')->toArray();
            $min_image = min($image);
            $max_image = max($image);

            foreach ($places as $placeName) {
                Product::create([
                    'uid'                   => $baseController->generateUID('product', 4),
                    'bar_code_id'           => $this->generateRandomNumber(),
                    'product_category_id'   => $productCategoryModel->id,
                    'name'                  => $placeName,
                    'image_id'              => rand($min_image['id'], $max_image['id']),
                    'status'                => rand(0, 1),
                    'created_at'            => Carbon::now()->addMinutes(1),
                    'updated_at'            => Carbon::now()->addMinutes(1),
                    // Add other fields if needed
                ]);
            }
        }
    }

    private function generateRandomNumber($length = 13)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
