
public function showRecipes(): JsonResponse
    {
        // display idresep, judul, status_resep, user_email, updated_at, gambar

        $recipes = Recipe::select('idresep', 'judul', 'status_resep', 'user_email', 'updated_at', 'gambar')->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Recipes Found',
            'data' => [
                'recipes' => [
                    $recipes
                ]
            ]
        ], 200);
    }

    public function showRecipeById($id): JsonResponse
    {
        $recipe = Recipe::where('idresep', $id)->first();

        if (!$recipe) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Not Found'
            ], 404);
        }

        $ingredients = Ingredient::where('resep_idresep', $id)->get();
        $tools = Tool::where('resep_idresep', $id)->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Recipe Found',
            'data' => [
                'recipe' => [
                    $recipe
                ],
                'ingredients' => [
                    $ingredients
                ],
                'tools' => [
                    $tools
                ]
            ]
        ], 200);
    }
