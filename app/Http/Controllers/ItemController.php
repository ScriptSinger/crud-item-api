<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
