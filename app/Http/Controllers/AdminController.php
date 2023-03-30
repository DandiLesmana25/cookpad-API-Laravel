<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use App\Models\User;   //call user model
use App\Models\Recipe;   
use App\Models\Tool;   //call Tool model
use App\Models\Ingredient;   

use Illuminate\Support\Facades\DB;   //call query builder


class AdminController extends Controller
{


    public function register(Request $request)
    {


        //create input validation
        $validator = Validator::make($request->all(), [
            'nama' => 'required',                           //nama harus/wajib di idi 
            'email' => 'required|email|unique:user,email',  //email harus di isi berformat emaol dan unik
            'password' => 'required|min:8',   
            'confirmation_password' => 'required|same:password',                //password harus di idi ,in 8 karakter
            'role' => 'required|in:admin,user',  //konfirmasi password harus di isi dan sesuai/sama dengan password
            'status' => 'required|in:aktif,non-aktif',  //konfirmasi password harus di isi dan sesuai/sama dengan password
            'email_validate' => 'required|email'  //konfirmasi password harus di isi dan sesuai/sama dengan password

        ]);
        
        // pengkomdidian ketika satu atau lebih inputan tidak sesuai aturan di atas/validation rule
        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        $user = $validator->validated();

        // memasukan ke database tabel user
        User::create($user);

        // isi token jwt
        
        //kirim response ke pengguna
        return response()->json([
            "data" => [
                'msg' => "berhasil login",
                'nama' => $user['nama'],
                'email' =>$user['email'],
                'role' => $user['role'],
            ]
            // "token" => "bearer {$token}"
        ],200);

    }

    
     /* for show all account 
    
    */
    
    public function show_register()
    {

        //memunculkan semua akun dengan role
        $users= User::where('role','user')->get();

        return response()->json([
            "data" => [
                'msg' => "user registrasi",
                'data' => $users
            ]
        ],200);


    }

     /* for show detail account by id as key params
    
    */
    public function show_register_by_id($id)
    {
        //memunculkan  akun berdasarkan id
        $user= User::find($id);

        return response()->json([
            "data" => [
                'msg' => "user id: {$id}",
                'data' => $user
            ]
        ],200);


    }

   /* for update account
    
    */
    public function update_register(Request $request,$id)
    {
        $user = User::find($id);

        //create input validation
       if($user) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',                           //nama harus/wajib di idi 
            // 'email' => 'required|email|unique:user,email ',  //email harus di isi berformat emaol dan unik
            'password' => 'min:8',   
            'confirmation_password' => 'same:password',                //password harus di idi ,in 8 karakter
            'role' => 'required|in:admin,user',  //konfirmasi password harus di isi dan sesuai/sama dengan password
            'status' => 'required|in:aktif,non-aktif',  //konfirmasi password harus di isi dan sesuai/sama dengan password
            'email_validate' => 'required|email'  //konfirmasi password harus di isi dan sesuai/sama dengan password

        ]);

        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        $data = $validator->validated();
        User::where('id',$id)->update($data);
        return response()->json([
            "data" => [
                'msg' => "'user dengan id: {$id} berhasil diupdate",
                'nama' => $data['nama'],
                'email' =>$user['email'],
                'role' => $data['role'],
            ]
        ],200);
       }
       return response()->json([
        "data" => [
            'msg' => "user id: {$id}, tidak ditemukan"
        ]
    ],200);    
    }

   /* for delete  account
    
    */
    public function delete_register($id) 
    {
        $user = User::find($id);

        if($user) 
        {
            $user->delete();

            return response()->json([
                "data" => [
                    'msg' => "'user dengan id : {$id} berhasil dihapus"
                ]
            ],200);
    

        }

        return response()->json([
            "data" => [
                'msg' => "'user dengan id: {$id} tidak ditemukan"
            ]
        ],422);

    }

    /* for aktivation account
    
    */

    public function activation_account($id) 
    {
        $user = User::find($id);

        if($user) 
        {
            User::where('id',$id)->update(['status' => 'aktif']);

            return response()->json([
                "data" => [
                    'msg' => "'user dengan id " .$id. " berhasil diaktifkan"
                ]
            ],200);
    

        }

        return response()->json([
            "data" => [
                'msg' => "user dengan id {$id} tidak ditemukan"
            ]
        ],422);

    }

    /* for deaktivation/nonaktif account
    
    */
    public function deactivation_account($id) 
    {
        $user = User::find($id);

        if($user) 
        {
            User::where('id',$id)->update(['status' => 'non-aktif']);

            return response()->json([
                "data" => [
                    'msg' => "'user dengan id " .$id. " berhasil dinonaktifkan"
                ]
            ],200);
    

        }

        return response()->json([
            "data" => [
                'msg' => "user dengan id {$id} tidak ditemukan"
            ]
        ],422);

    }

       /* for create recipe
    
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


    
       /* for update  recipe
    
    */
    public function update_recipe(Request $request, $id)
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

        $recipeData = $validator->validated();

        Recipe::where('idresep'.$id)->update([
            'judul' => $recipeData['judul'],
            'gambar' => 'uploads/'.$filename,    //cukup masukan path dari gambar yang di uploads
            'cara_pembuatan' =>$recipeData['cara_pembuatan'],
            'video' =>$recipeData['video'],
            'user_email' =>$recipeData['user_email'],
            'status_resep' => 'submit'

        ]);

        // hapus alat dan bahan sebelumnya
        Ingredient::where('resep_idresep', $id)->delete();
        Tool::where('resep_idresep', $id)->delete();
        
        // perulangan untuk memasukan data bahan lebih dari satu 
        foreach(json_decode($request->bahan) as $bahan) {

            Ingredient::create([
                'nama' => $bahan->nama,
                'satuan' => $bahan->satuan,
                'banyak' => $bahan->banyak,
                'keterangan' => $bahan->keterangan,
                'resep_idresep' => $id,
    
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
        ],200);

    }


    
    /* for delete recipe
    
    */
    public function delete_recipe($id)
    {


        Tool::where('resep_idresep', $id)->delete();
        Ingredient::where('resep_idresep', $id)->delete();
        Recipe::where('idresep', $id)->delete();

        return response()->json([
            "data" => [
                'msg' => "resep berhasil dihapus",
                'resep' => $id
            ]
        ],200);

    }


    public function publish_recipe($id)
    {
        $recipe= Recipe::where('idresep',$id)->get();

        if($recipe) {
            Recipe::where('idresep',$id)->update(['status_resep'=> 'publish']);

            \App\Models\Log::create([
                'module' => 'publish resep',
                'action' => 'publish resep dengan id'.$id,
                'useraccess' => 'administrator'

            ]);

            return response()->json([
                "data" => [
                    'msg' => "resep dengan id".$id."berhasil di publish",
                ]
            ],200);
        }

        return response()->json([
            "data" => [
                'msg' => "resep dengan id".$id."tidak ditemukan",
            ]
        ],422);


     

    }

    public function unpublish_recipe($id)
    {
        $recipe= Recipe::where('idresep',$id)->get();

        if($recipe) {
            Recipe::where('idresep',$id)->update(['status_resep'=> 'unpublish']);

            \App\Models\Log::create([
                'module' => 'publish resep',
                'action' => 'unpublish resep dengan id'.$id,
                'useraccess' => 'administrator'

            ]);

            return response()->json([
                "data" => [
                    'msg' => "resep dengan id".$id."berhasil di unpublish",
                ]
            ],200);
        }

        return response()->json([
            "data" => [
                'msg' => "resep dengan id".$id."tidak ditemukan",
            ]
        ],422);     
    }

    
    public function dashboard()
    {
        $totalRecipes= Recipe::count();
        $totalPublishRecipes = Recipe::where('status_resep', 'publish')->count();
        $popularRecipe = DB::table('resep')
        ->select('judul',DB::raw('count(idresep_view) as jumlah'))
        ->leftJoin('resep_view','resep.id_resep', '=','resep_view.resep_idresep')
        ->groupBy('judul')
        ->orderBy(DB::raw('count(idresep_view)'),'desc')
        ->limit('10')
        ->get();



        return response()->json([
            "data" => [
                'msg' => "dashboard monitoring",
                'totalRecipes' =>$totalRecipes,
                'totalPublishRecipes' =>$totalPublishRecipes,
                'popularRecipe' =>$popularRecipe,
            ]
        ],200);


     

    }
}
