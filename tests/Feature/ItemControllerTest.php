<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */


    use RefreshDatabase;

    public function testCreateItem()
    {
        // Создание фейковых данных для элемента
        $data = [
            'name' => 'Новый элемент',
            'phone' => '1234567890',
            'key' => 'ключ123',
        ];

        // Отправка POST-запроса на создание элемента
        $response = $this->json('POST', '/api/items', $data);

        // Проверка, на то что создание элемента было успешным (код ответа 201)
        $response->assertStatus(201);

        // Проверка, что в ответе есть сообщение об успешном создании
        $response->assertJson(['message' => 'Элемент успешно создан']);

        // Проверка, на то что элемент был создан в базе данных
        $this->assertDatabaseHas('items', $data);
    }
}
