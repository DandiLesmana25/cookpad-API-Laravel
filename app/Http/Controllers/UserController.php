<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Tool;   //call Tool model
use App\Models\Ingredient; 
use Illuminate\Support\Facades\Validator;  //callthe validator library for input validation

class UserController extends Controller
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
    public function create_recipe(Request $request)
    {
         //create input validation
        $validator = Validator::make($request->all(), [
            'judul' => 'required|max:255',                           
            'gambar' => 'required|mimes:png,jpg,jpeg|max2048',  //gambar harus bertipe  png,jpg,jpeg| dan max 2 mb
            'cara_pembuatan' => 'required',   
            'video' => 'required',              
            'user_email' => 'required', 
            'bahan' => 'required',  
            'alat' => 'required'  

        ]);

        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }


        $thumbnail = $request->file('gambar');

        // ubah nama file yang akan dimasukan ke server
        $filename = now()->timestamp."_".$request->gambar->getClientOriginalName();
        $thumbnail = move('uploads', $filename);  //upload gambar ke folder upluads

        $recipe = Recipe::create([
            'judul' => $recipeData['judul'],
            'gambar' => 'uploads/'.$filename,    //cukup masukan path dari gambar yang di uploads
            'cara_pembuatan' =>$recipeData['cara_pembuatan'],
            'video' =>$recipeData['video'],
            'user_email' =>$recipeData['user_email'],
            'status_resep' => 'submit'

        ]);
        
        // perulangan untuk memasukan data bahan lebih dari satu 
        foreach(json_decode($request->bahan) as $bahan) {

            Ingredient::create([
                'nama' => $bahan->nama,
                'satuan' => $bahan->satuan,
                'banyak' => $bahan->banyak,
                'keterangan' => $bahan->keterangan,
                'resep_idresep' => $recipe->id,
    
            ]);
        }
        

         // perulangan untuk memasukan data alat lebih dari satu 
         foreach(json_decode($request->alat) as $alat) {

            Tool::create([
                'nama_alat' => $alat->nama,
                'keterangan' => $alat->keterangan,
                'resep_idresep' => $recipe->id,
    
            ]);
        }

        return response()->json([
            "data" => [
                'msg' => "resep berhasil di simpan",
                'resep' => $recipeData['judul']
            ]
        ]);

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
