<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="crud-item-api",
 *     version="1.0.0",
 *     description="Это пример API для управления элементами. API предоставляет методы для создания, обновления, получения и удаления элементов",
 *     @OA\Contact(
 *         email="heturion@gmail.com"
 *     )
 * )
 */
class ItemController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/items",
     *     summary="Создать новый элемент",
     *     tags={"Items"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=255),
     *             @OA\Property(property="phone", type="string", maxLength=15),
     *             @OA\Property(property="key", type="string", maxLength=25),
     *         )
     *     ),
     *     @OA\Response(response=201, description="Элемент успешно создан"),
     * )
     */
    public function store(Request $request)
    {
        // Валидация полей
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'key' => 'required|string|max:25',
        ]);

        // Создание нового элемента
        $item = new Item([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'key' => $request->input('key'),
        ]);

        $item->save();

        // Возвращение успешного ответа
        return response()->json(['message' => 'Элемент успешно создан'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/items/{id}",
     *     summary="Получить информацию о элементе",
     *     tags={"Items"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Идентификатор элемента",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Информация о элементе"),
     *     @OA\Response(response=404, description="Элемент не найден"),
     * )
     */
    public function show(string $id)
    {
        // Поиск элемента
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Элемент не найден'], 404);
        }

        // Возвращение информации о элементе
        return response()->json($item, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/items/{id}",
     *     summary="Обновить элемент",
     *     tags={"Items"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Идентификатор элемента",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=255),
     *             @OA\Property(property="phone", type="string", maxLength=15),
     *             @OA\Property(property="key", type="string", maxLength=25),
     *         )
     *     ),
     *     @OA\Response(response=200, description="Элемент успешно обновлен"),
     *     @OA\Response(response=404, description="Элемент не найден"),
     * )
     */
    public function update(Request $request, string $id)
    {
        // Валидация полей
        $request->validate([
            'name' => 'string|max:255',
            'phone' => 'string|max:15',
            'key' => 'string|max:25',
        ]);

        // Поиск элемента
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Элемент не найден'], 404);
        }

        // Обновление полей
        if ($request->has('name')) {
            $item->name = $request->input('name');
        }
        if ($request->has('phone')) {
            $item->phone = $request->input('phone');
        }
        if ($request->has('key')) {
            $item->key = $request->input('key');
        }

        $item->save();

        // Возвращение успешного ответа
        return response()->json(['message' => 'Элемент успешно обновлен'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/items/{id}",
     *     summary="Удалить элемент",
     *     tags={"Items"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Идентификатор элемента",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Элемент успешно удален"),
     *     @OA\Response(response=404, description="Элемент не найден"),
     * )
     */
    public function destroy(string $id)
    {
        // Поиск элемента
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Элемент не найден'], 404);
        }

        // Удаление элемента
        $item->delete();

        // Возвращение успешного ответа
        return response()->json(['message' => 'Элемент успешно удален'], 200);
    }

    public function history(Request $request, $id)
    {
        // Поиск элемента
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // Получение истории изменений
        $history = $item->history;

        return response()->json(['history' => $history], 200);
    }
}
