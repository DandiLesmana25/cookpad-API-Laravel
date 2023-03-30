<?php

namespace App\Http\Controllers;

// use Dotenv\Validator;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show_recipes()
    {
        //panggil resep yang berstatus publish dan relasinya dengan tabel user
        $recipes = Recipe::with('user')->where('status_resep','publish')->get();

        $data = [];
        foreach($recipes as $recipe)
        {
            array_push($data,[
                'idresep' => $recipe->idresep,
                'judul' => $recipe->judul,
                'gambar' => url($recipe->gambar),
                'nama' => $recipe->user->nama,
            ]);
        }
        return response()->json($data, 200);

    }

    /**
     * Show the form for creating a new resource.
     */

     public function recipe_by_id(Request $request)
     {
          //create input validation
         $validator = Validator::make($request->all(), [
             'idresep' => 'required',  
             'email' => 'email'  
 
         ]);
 
         if($validator->fails()) {
             return messageError($validator->messages()->toArray());
         }

         $recipe = Recipe::where('status_resep', 'publish')
        ->where('idresep', $request->idresep)->get();
        
        $tools = Tool::where('resep_idresep', $request->idresep)->get();
        $ingredients = Ingredients::where('resep_idresep', $request->idresep)->get();

        
        $data = [];
         // perulangan untuk memasukan data lebih dari satu 
         foreach($recipe as $recipe) {
            array_push($data,[
                'idresep' => $recipe->idresep,
                'judul' => $recipe->judul,
                'gambar' => url($recipe->gambar),
                'cara_pembuatan' => $recipe->cara_pembuatan,
                'video' => $recipe->video,
                'nama' => $recipe->user->nama
            ]);
         }

         $recipeData= [
            'recipe' => $data,
            'tools' => $tools,
            'ingredients' => $ingredients

         ];

        //  memasukan data yang melihat resep ini
        \App\Models\RecipeView::create([
            'email' => $request->email,
            'date' => $now(),
            'resep_idresep' => $request->idresep,
        ]);
        
        return response()->json($recipeData,200);
 
     }


    /**
     * Store a newly created resource in storage.
     */

     public function rating(Request $request)
     {
          //create input validation
         $validator = Validator::make($request->all(), [
             'idresep' => 'required',  
             'email' => 'required|email',  
             'rating' => 'required|in: 1,2,3,4,5'  
 
         ]);
 
         if($validator->fails()) {
             return messageError($validator->messages()->toArray());
         }

        //  memasukan data R
        \App\Models\Rating::create([
            'rating' => $request->rating,
            'review' => $request->review,
            'resep_idresep' => $request->id_resep,
            'email_user' => $request->email,
        ]);
        
        return response()->json([
            'data' => [
                'msg' => 'rating berhasil disimpan'
            ]
        ]);
 
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
