<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([

            [
                'typeGroups_id' => '1',
                'name' => 'Bútor'
            ],
            [
                'typeGroups_id' => '1',
                'name' => 'Ékszer'
            ],
            [
                'typeGroups_id' => '1',
                'name' => 'Ereklye'
            ],
            [
                'typeGroups_id' => '1',
                'name' => 'Fegyver'
            ],
            [
                'typeGroups_id' => '1',
                'name' => 'Jármű'
            ],
            [
                'typeGroups_id' => '1',
                'name' => 'Óra'
            ],
            [
                'typeGroups_id' => '1',
                'name' => 'Páncélzat'
            ],
            [
                'typeGroups_id' => '1',
                'name' => 'Pénz'
            ],
            [
                'typeGroups_id' => '1',
                'name' => 'Egyéb antik tárgy'
            ],
            [
                'typeGroups_id' => '2',
                'name' => 'Hálószobabútor'
            ],
            [
                'typeGroups_id' => '2',
                'name' => 'Irodabútor'
            ],
            [
                'typeGroups_id' => '2',
                'name' => 'Kerti bútor'
            ],
            [
                'typeGroups_id' => '2',
                'name' => 'Konyhabútor'
            ],
            [
                'typeGroups_id' => '2',
                'name' => 'Nappalibútor'
            ],
            [
                'typeGroups_id' => '2',
                'name' => 'Egyéb bútor'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Asztali számítógép'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Audió'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Hálózati eszköz'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Játékkonzol'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Laptop'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Mobiltelefon'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Monitor és TV'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Okosóra'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Számítógép-kiegészítő'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Tablet'
            ],
            [
                'typeGroups_id' => '3',
                'name' => 'Egyéb elektronikus eszköz'
            ],
            [
                'typeGroups_id' => '4',
                'name' => 'Bross vagy kitűző'
            ],
            [
                'typeGroups_id' => '4',
                'name' => 'Fülbevaló'
            ],
            [
                'typeGroups_id' => '4',
                'name' => 'Gyűrű'
            ],
            [
                'typeGroups_id' => '4',
                'name' => 'Hajpánt'
            ],
            [
                'typeGroups_id' => '4',
                'name' => 'Karkötő'
            ],
            [
                'typeGroups_id' => '4',
                'name' => 'Karóra'
            ],
            [
                'typeGroups_id' => '4',
                'name' => 'Nyaklánc'
            ],
            [
                'typeGroups_id' => '4',
                'name' => 'Egyéb ékszer vagy kiegészítő'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Babák és figurák'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Elektronikus játék'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Építőjáték'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Kerti és szabadtéri játék'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Kreatív játék'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Oktató és fejlesztő játék'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Plüssjáték'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Szerepjáték'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Társasjáték gyermekeknek'
            ],
            [
                'typeGroups_id' => '5',
                'name' => 'Egyéb gyermekjáték'
            ],
            [
                'typeGroups_id' => '6',
                'name' => 'Háztartási kisgép'
            ],
            [
                'typeGroups_id' => '6',
                'name' => 'Konyhai eszköz'
            ],
            [
                'typeGroups_id' => '6',
                'name' => 'Tárolás és rendszerezés'
            ],
            [
                'typeGroups_id' => '6',
                'name' => 'Világítás'
            ],
            [
                'typeGroups_id' => '6',
                'name' => 'Egyéb háztartási eszköz'
            ],
            [
                'typeGroups_id' => '7',
                'name' => 'Gyűjthető tárgy'
            ],
            [
                'typeGroups_id' => '7',
                'name' => 'Kártyajáték'
            ],
            [
                'typeGroups_id' => '7',
                'name' => 'Modellépítés'
            ],
            [
                'typeGroups_id' => '7',
                'name' => 'Társasjáték'
            ],
            [
                'typeGroups_id' => '7',
                'name' => 'Egyéb hobbi és gyűjtemény'
            ],
            [
                'typeGroups_id' => '8',
                'name' => 'Járműalkatrész vagy -kiegészítő'
            ],
            [
                'typeGroups_id' => '8',
                'name' => 'Kerékpár'
            ],
            [
                'typeGroups_id' => '8',
                'name' => 'Motorkerékpár'
            ],
            [
                'typeGroups_id' => '8',
                'name' => 'Személyautó'
            ],
            [
                'typeGroups_id' => '8',
                'name' => 'Teherautó'
            ],
            [
                'typeGroups_id' => '8',
                'name' => 'Egyéb jármű'
            ],
            [
                'typeGroups_id' => '9',
                'name' => 'Fegyverutánzat'
            ],
            [
                'typeGroups_id' => '9',
                'name' => 'Ruházat és kiegészítő'
            ],
            [
                'typeGroups_id' => '9',
                'name' => 'Túlélőfelszerelés'
            ],
            [
                'typeGroups_id' => '9',
                'name' => 'Egyéb katonai eszköz'
            ],
            [
                'typeGroups_id' => '10',
                'name' => 'Film'
            ],
            [
                'typeGroups_id' => '10',
                'name' => 'Képregény'
            ],
            [
                'typeGroups_id' => '10',
                'name' => 'Könyv'
            ],
            [
                'typeGroups_id' => '10',
                'name' => 'Magazin és újság'
            ],
            [
                'typeGroups_id' => '10',
                'name' => 'Szoftver'
            ],
            [
                'typeGroups_id' => '10',
                'name' => 'Zene'
            ],
            [
                'typeGroups_id' => '10',
                'name' => 'Egyéb média'
            ],
            [
                'typeGroups_id' => '11',
                'name' => 'Festmény'
            ],
            [
                'typeGroups_id' => '11',
                'name' => 'Fénykép'
            ],
            [
                'typeGroups_id' => '11',
                'name' => 'Rajz'
            ],
            [
                'typeGroups_id' => '11',
                'name' => 'Szobor'
            ],
            [
                'typeGroups_id' => '11',
                'name' => 'Egyéb művészet'
            ],
            [
                'typeGroups_id' => '12',
                'name' => 'Arany'
            ],
            [
                'typeGroups_id' => '12',
                'name' => 'Bronz'
            ],
            [
                'typeGroups_id' => '12',
                'name' => 'Ezüst'
            ],
            [
                'typeGroups_id' => '12',
                'name' => 'Platina'
            ],
            [
                'typeGroups_id' => '12',
                'name' => 'Egyéb nemesfém'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Egyberuha'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Jelmez'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Kabát'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Kesztyű'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Lábbeli'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Nadrág'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Öltöny'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Sapka, kalap'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Sportruházat'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Szoknya'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Sál'
            ],
            [
                'typeGroups_id' => '13',
                'name' => 'Egyéb ruhadarab'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Extrém sport'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Fitness és edzés'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Horgászat'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Labda'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Lovaglás'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Téli sportok'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Ütő'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Vívás'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Vízi sportok'
            ],
            [
                'typeGroups_id' => '14',
                'name' => 'Egyéb sporteszköz'
            ],
            [
                'typeGroups_id' => '15',
                'name' => 'Barkácsszerszám'
            ],
            [
                'typeGroups_id' => '15',
                'name' => 'Mezőgazdasági szerszám'
            ],
            [
                'typeGroups_id' => '15',
                'name' => 'Egyéb szerszám'
            ],
            [
                'typeGroups_id' => '16',
                'name' => 'Egyéb'
            ]

        ]);

    }
}
