<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;
use Validator;

class categoryController extends Controller{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $categories = Category::all();
        foreach($categories as $category){
            $category->sub_category;

            if($category->Image == null){
                $category->Image = "null";
            }
        }
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'category_id' => 'integer|exists:App\Category,id',
            'category_title' => 'string',
            'sub_category_title' => 'string|required',
        ], [
            'category_id.integer' => 'category_id must be an integer!',
            'category_id.exists' => 'category_id does not exist!',
            'category_title.string' => 'category_id must be a string',
            'sub_category_title.string' => 'sub_category_title must be a string',
            'sub_category_title.required' => 'sub_category_title is required!',
        ]);

        if($validator->fails()){
            return response()->json([
                "responseCode" => 401,
                "errorCode" => 'incomplete data',
                'message' => $validator->errors(),
            ], 401);
        }

        if(isset($request->category_id)){
            if($request->category_id != null){
                SubCategory::create([
                    "Title" => $request->sub_category_title,
                    "Parent" => $request->category_id,
                ]);
                return response()->json(["success" => ["message" => "sub category created!"]], 200);
            }
        } elseif(isset($request->category_title)){
            if($request->category_title != null){
                $category = Category::create([
                    'Title' => $request->category_title,
                ]);

                SubCategory::create([
                    "Title" => $request->sub_category_title,
                    "Parent" => $category->id,
                ]);
                return response()->json(["success" => ["message" => "sub category and category created!"]], 200);
            }
        }

        return response()->json(["error" => ["message" => "category id and category title are null"]], 400);

    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
}
