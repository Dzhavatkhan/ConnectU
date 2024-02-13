<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            "categories" => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $name = $request->name;

        if (!$name) {
            return response()->json([
                "error" => "Ничего не введено"
            ], 502);
        }

        $check_unique = Category::where('name', $name)->first();

        if ($check_unique) {
            return response()->json([
                "error" => "Такая категория уже есть."
            ], 502);
        }

        $category_created = Category::create([
            "name" => $name
        ]);

        return response()->json([
            "category" => $category_created
        ],201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->name;
        $category = Category::findOrFail($id);
        if (isset($name)) {
            $uniq_category = Category::where("name", $name)->count();
            if ($uniq_category > 0) {
                return response()
                ->json([
                    "message" => "Такая категория уже есть"
                ]);
            } else {
                $category->update([
                    "name" => $name
                ]);
            }



            return response()
            ->json([
                "message" => "Успешно отредактировано"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        DB::table("posts_categories")->where("category_id", $id)->delete();
        User_category::where("category_id", $id)->delete();
        $category->delete();
        return response()->json(
            [
                "category" => "$category->name удалено."
            ]
            );
    }
}
