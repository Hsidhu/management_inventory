<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;
use App\Product;
use App\ProductBalance;
use App\Provider;


// /Applications/MAMP/bin/php/php7.4.21/bin/php artisan db:seed --class=ProductSeeder
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::insert([
            [
                'name' => 'Abrasives',
                'description' => ''
            ],
            [
                'name' => 'Acrylics',
                'description' => ''
            ],
            [
                'name' => 'Alloys',
                'description' => ''
            ],
            [
                'name' => 'Anesthetics',
                'description' => ''
            ],
            [
                'name' => 'Articulating Paper',
                'description' => ''
            ],
            [
                'name' => 'Bleaching & Whitening',
                'description' => ''
            ],
            [
                'name' => 'Bonds & Cements',
                'description' => ''
            ],
            [
                'name' => 'Bulbs',
                'description' => ''
            ],
            [
                'name' => 'Burs',
                'description' => ''
            ],
            [
                'name' => 'CAD/CAM',
                'description' => ''
            ],
            [
                'name' => 'Composites & Restoratives',
                'description' => ''
            ],
            [
                'name' => 'Crowns & Shells',
                'description' => ''
            ],
            [
                'name' => 'Diamonds',
                'description' => ''
            ],
            [
                'name' => 'Disposables',
                'description' => ''
            ],
            [
                'name' => 'Endodontics',
                'description' => ''
            ],
            [
                'name' => 'Gloves',
                'description' => ''
            ],
            [
                'name' => 'Impression Materials',
                'description' => ''
            ],
            [
                'name' => 'Infection Control',
                'description' => ''
            ],
            [
                'name' => 'Instruments',
                'description' => ''
            ],
            [
                'name' => 'Laboratory',
                'description' => ''
            ],
            [
                'name' => 'Lubricants & Cleaners',
                'description' => ''
            ],
            [
                'name' => 'Matrix',
                'description' => ''
            ],
            [
                'name' => 'Miscellaneous',
                'description' => ''
            ],
            [
                'name' => 'Organizational Items',
                'description' => ''
            ],
            [
                'name' => 'Pins & Posts',
                'description' => ''
            ],
            [
                'name' => 'Preventative & Prophy',
                'description' => ''
            ],
            [
                'name' => 'Retraction Materials',
                'description' => ''
            ],
            [
                'name' => 'Rubber Dam',
                'description' => ''
            ],
            [
                'name' => 'Saliva & Evacuation',
                'description' => ''
            ],
            [
                'name' => 'Surgical',
                'description' => ''
            ],
            [
                'name' => 'Toys',
                'description' => ''
            ],
            [
                'name' => 'Waxes',
                'description' => ''
            ],
            [
                'name' => 'X-Ray',
                'description' => ''
            ],
        ]);

        Product::insert([
            [
                'name' => 'Alpen Minipoint',
                'description' => '',
                'alert_level' => 5,
                'product_category_id' => 1
            ],
            [
                'name' => 'Alpen Plus Minipoint RA Fine',
                'description' => '',
                'alert_level' => 5,
                'product_category_id' => 1
            ]
        ]);

        ProductBalance::insert([
            [
                'product_id' => 1
            ],
            [
                'product_id' => 2
            ]
        ]);


        Provider::create([
            'name' => 'sinclairdental',
            'description' => '',
            'email'=> 'info@SinclairDental.com',
            'website' => 'https://www.sinclairdental.com/',
            'phone' => '6049861544'
        ]);
    }
}
