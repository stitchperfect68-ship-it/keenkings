<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::truncate();

        $clients = [
            // Row 1 — scrolls left (7 logos)
            ['name' => 'Client 1',  'row' => 1, 'sort_order' => 1, 'logo_url' => 'https://i.ibb.co/TGGsPrV/p1-4.png'],
            ['name' => 'Client 2',  'row' => 1, 'sort_order' => 2, 'logo_url' => 'https://i.ibb.co/fY01Xd7V/p1-5.png'],
            ['name' => 'Client 3',  'row' => 1, 'sort_order' => 3, 'logo_url' => 'https://i.ibb.co/7d4LMWj6/p1-6.png'],
            ['name' => 'Client 4',  'row' => 1, 'sort_order' => 4, 'logo_url' => 'https://i.ibb.co/HDcpYm59/p1-7.png'],
            ['name' => 'Client 5',  'row' => 1, 'sort_order' => 5, 'logo_url' => 'https://i.ibb.co/mmBhSPg/p1-8.png'],
            ['name' => 'Client 6',  'row' => 1, 'sort_order' => 6, 'logo_url' => 'https://i.ibb.co/cKb4zsNZ/p1-9.png'],
            ['name' => 'Client 7',  'row' => 1, 'sort_order' => 7, 'logo_url' => 'https://i.ibb.co/whk0T7fq/p1-10.png'],

            // Row 2 — scrolls right (7 logos)
            ['name' => 'Client 8',  'row' => 2, 'sort_order' => 1, 'logo_url' => 'https://i.ibb.co/nsWzWBW8/p1-11.png'],
            ['name' => 'Client 9',  'row' => 2, 'sort_order' => 2, 'logo_url' => 'https://i.ibb.co/ZRN1NcQd/p1-12.png'],
            ['name' => 'Client 10', 'row' => 2, 'sort_order' => 3, 'logo_url' => 'https://i.ibb.co/hRvw76bb/p1-13.png'],
            ['name' => 'Client 11', 'row' => 2, 'sort_order' => 4, 'logo_url' => 'https://i.ibb.co/dwtD75v9/p1-14.png'],
            ['name' => 'Client 12', 'row' => 2, 'sort_order' => 5, 'logo_url' => 'https://i.ibb.co/67DM1qQs/p1-15.png'],
            ['name' => 'Client 13', 'row' => 2, 'sort_order' => 6, 'logo_url' => 'https://i.ibb.co/fdsx2Yvc/p1-16.png'],
            ['name' => 'Client 14', 'row' => 2, 'sort_order' => 7, 'logo_url' => 'https://i.ibb.co/DPdyGCZx/p1-17.png'],

            // Row 3 — scrolls left, slower (7 logos)
            ['name' => 'Client 15', 'row' => 3, 'sort_order' => 1, 'logo_url' => 'https://i.ibb.co/fV5NHGFb/p1-18.png'],
            ['name' => 'Client 16', 'row' => 3, 'sort_order' => 2, 'logo_url' => 'https://i.ibb.co/PGyXJLkK/p1-19.png'],
            ['name' => 'Client 17', 'row' => 3, 'sort_order' => 3, 'logo_url' => 'https://i.ibb.co/fYx0mhK5/p1-20.png'],
            ['name' => 'Client 18', 'row' => 3, 'sort_order' => 4, 'logo_url' => 'https://i.ibb.co/Z6Fpfq0s/p1-21.png'],
            ['name' => 'Client 19', 'row' => 3, 'sort_order' => 5, 'logo_url' => 'https://i.ibb.co/9k0BkXr9/p1-22.png'],
            ['name' => 'Client 20', 'row' => 3, 'sort_order' => 6, 'logo_url' => 'https://i.ibb.co/MxHzXqDh/p1-23.png'],
            ['name' => 'Client 21', 'row' => 3, 'sort_order' => 7, 'logo_url' => 'https://i.ibb.co/ZpfgbxHH/p1-24.png'],
        ];

        foreach ($clients as $c) {
            Client::create($c + ['is_active' => true]);
        }
    }
}
