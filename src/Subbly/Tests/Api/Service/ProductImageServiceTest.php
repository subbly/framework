<?php

use Subbly\Subbly;
use Subbly\Api\Api;
use Subbly\Api\Service\ProductImageService;
use Subbly\Framework\Container;
use Subbly\Tests\Support\TestCase;

class ProductImageServiceTest extends TestCase
{
    private function getService()
    {
        return Subbly::api('subbly.product_image');
    }

    public function testConstruct()
    {
        $api = new Api(new Container(), array());
        $s   = new ProductImageService($api);

        $this->assertNotNull($s);
    }

    public function testNewProductImage()
    {
        $instance = $this->getService()->newProductImage();
        $this->assertInstanceOf('Subbly\\Model\\ProductImage', $instance);
    }

    public function testFind()
    {
        $fixture = TestCase::getFixture('product_images.product_image_4');
        $uid     = $fixture->uid;
        $productImage = $this->getService()->find($uid);

        $this->assertInstanceOf('Subbly\\Model\\ProductImage', $productImage);
        $this->assertEquals($fixture->name, $productImage->name);
    }

    public function testFindByProduct()
    {
        // TODO
    }

    public function testCreate()
    {
        // TODO
    }

    public function testUpdate()
    {
        // TODO
    }

    public function testDelete()
    {
        // TODO
    }

    public function testName()
    {
        $this->assertEquals($this->getService()->name(), 'subbly.product_image');
    }
}
