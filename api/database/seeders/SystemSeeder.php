<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared("INSERT INTO `country` (`id`, `name`, `iso2`, `iso3`, `phone_code`, `currency`, `native`) VALUES
(1, 'Turkey', 'TR', 'TUR', '90', 'TRY', 'Türkiye')");


        DB::unprepared("INSERT INTO `state` (`id`, `name`, `country_id`, `country_code`, `iso2`) VALUES
(1, 'Adana', 1, '', ''),
(2, 'Adıyaman', 1, NULL, NULL),
(3, 'Afyonkarahisar', 1, NULL, NULL),
(4, 'Ağrı', 1, NULL, NULL),
(5, 'Aksaray', 1, NULL, NULL),
(6, 'Amasya', 1, NULL, NULL),
(7, 'Ankara', 1, NULL, NULL),
(8, 'Antalya', 1, NULL, NULL),
(9, 'Ardahan', 1, NULL, NULL),
(10, 'Artvin', 1, NULL, NULL),
(11, 'Aydın', 1, NULL, NULL),
(12, 'Balıkesir', 1, NULL, NULL),
(13, 'Bartın', 1, NULL, NULL),
(14, 'Batman', 1, NULL, NULL),
(15, 'Bayburt', 1, NULL, NULL),
(16, 'Bilecik', 1, NULL, NULL),
(17, 'Bingöl', 1, NULL, NULL),
(18, 'Bitlis', 1, NULL, NULL),
(19, 'Bolu', 1, NULL, NULL),
(20, 'Burdur', 1, NULL, NULL),
(21, 'Bursa', 1, NULL, NULL),
(22, 'Çanakkale', 1, NULL, NULL),
(23, 'Çankırı', 1, NULL, NULL),
(24, 'Çorum', 1, NULL, NULL),
(25, 'Denizli', 1, NULL, NULL),
(26, 'Diyarbakır', 1, NULL, NULL),
(27, 'Düzce', 1, NULL, NULL),
(28, 'Edirne', 1, NULL, NULL),
(29, 'Elazığ', 1, NULL, NULL),
(30, 'Erzincan', 1, NULL, NULL),
(31, 'Erzurum', 1, NULL, NULL),
(32, 'Eskişehir', 1, NULL, NULL),
(33, 'Gaziantep', 1, NULL, NULL),
(34, 'Giresun', 1, NULL, NULL),
(35, 'Gümüşhane', 1, NULL, NULL),
(36, 'Hakkari', 1, NULL, NULL),
(37, 'Hatay', 1, NULL, NULL),
(38, 'Iğdır', 1, NULL, NULL),
(39, 'Isparta', 1, NULL, NULL),
(40, 'İstanbul', 1, NULL, NULL),
(41, 'İzmir', 1, NULL, NULL),
(42, 'Kahramanmaraş', 1, NULL, NULL),
(43, 'Karabük', 1, NULL, NULL),
(44, 'Karaman', 1, NULL, NULL),
(45, 'Kars', 1, NULL, NULL),
(46, 'Kastamonu', 1, NULL, NULL),
(47, 'Kayseri', 1, NULL, NULL),
(48, 'Kırıkkale', 1, NULL, NULL),
(49, 'Kırklareli', 1, NULL, NULL),
(50, 'Kırşehir', 1, NULL, NULL),
(51, 'Kilis', 1, NULL, NULL),
(52, 'Kocaeli', 1, NULL, NULL),
(53, 'Konya', 1, NULL, NULL),
(54, 'Kütahya', 1, NULL, NULL),
(55, 'Malatya', 1, NULL, NULL),
(56, 'Manisa', 1, NULL, NULL),
(57, 'Mardin', 1, NULL, NULL),
(58, 'Mersin', 1, NULL, NULL),
(59, 'Muğla', 1, NULL, NULL),
(60, 'Muş', 1, NULL, NULL),
(61, 'Nevşehir', 1, NULL, NULL),
(62, 'Niğde', 1, NULL, NULL),
(63, 'Ordu', 1, NULL, NULL),
(64, 'Osmaniye', 1, NULL, NULL),
(65, 'Rize', 1, NULL, NULL),
(66, 'Sakarya', 1, NULL, NULL),
(67, 'Samsun', 1, NULL, NULL),
(68, 'Siirt', 1, NULL, NULL),
(69, 'Sinop', 1, NULL, NULL),
(70, 'Sivas', 1, NULL, NULL),
(71, 'Şanlıurfa', 1, NULL, NULL),
(72, 'Şırnak', 1, NULL, NULL),
(73, 'Tekirdağ', 1, NULL, NULL),
(74, 'Tokat', 1, NULL, NULL),
(75, 'Trabzon', 1, NULL, NULL),
(76, 'Tunceli', 1, NULL, NULL),
(77, 'Uşak', 1, NULL, NULL),
(78, 'Van', 1, NULL, NULL),
(79, 'Yalova', 1, NULL, NULL),
(80, 'Yozgat', 1, NULL, NULL),
(81, 'Zonguldak', 1, NULL, NULL);");
    }
}
