<?php

namespace Subbly\Tests\Resources\database\seeds;

use Illuminate\Database\Seeder;
use Subbly\Model\ProductImage;
use Subbly\Tests\Support\TestCase;

class ProductImageTableSeeder extends Seeder
{
    public function run()
    {
        $faker = TestCase::faker();

        for ($i = 1; $i <= 10; $i++) {
            $productImage = ProductImage::create(array(
                'product_id' => TestCase::getFixture('products.product_1')->id,
                'name'       => $faker->name,
            ));
            TestCase::addFixture('product_images.product_image_'.$i, $productImage);
        }
    }
}
