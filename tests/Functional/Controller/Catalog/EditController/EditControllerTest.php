<?php

namespace App\Tests\Functional\Controller\Catalog\EditController;


use App\Tests\Functional\WebTestCase;

class EditControllerTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new EditControllerFixture());
    }

    public function test_edit_product(): void
    {
        $this->client->request('PUT', '/products/' . EditControllerFixture::PRODUCT_ID, [
            'name' => 'new name',
            'price' => 5000,
        ]);

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();

        self::assertEquals($response['id'], EditControllerFixture::PRODUCT_ID);
        self::assertEquals($response['name'], 'new name');
        self::assertEquals($response['price'], 5000);
    }
}
