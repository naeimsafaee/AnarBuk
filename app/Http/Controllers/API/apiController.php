<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Main;
use Illuminate\Http\Request;
use Validator;

class apiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = array();
//        $mains=Main::all();
        $mains = Main::where('type', 1)->get();
        $i = 0;
        foreach ($mains as $main) {
            $main->user;
            $res['data'][$i] = $main;

            if ($main->user->count() == 0) {
                $res['data'][$i]['user']['msg']='not f';
                $res['data'][$i]['user']['count']=0;
            }
            $i++;

        }

        return response()->json($res, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required',
            'type' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors(), "responseCode" => 401, "errorCode" => 'incomplete data'], 401);
        }

        $main = Main::Create([
            'user_id' => 1,
            'type' => $request->type,
            'name' => $request->name
        ]);

        return response()->json($main, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $res = new \stdClass();


//        $main = Main::find($id);
//        $main = Main::findOrFail($id);
        $main = Main::find($id);
        $main->user;


//        if ($main->count() == 0) {
//            $err = new \stdClass();
//            $err->msg = 'not found';
//            return response()->json($err, 404);
//        }


        return response()->json($main, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $main=Main::find($id);
//        $main->type=$request->type;
//        $main->name=$request->name;
//        $main->save();

        try {
            $main = Main::UpdateOrCreate(
                ["id" => $id]
                ,
                [
                    "user_id" => 1,
                    "type" => $request->type,
                    "name" => $request->name
                ]
            );

            return response()->json($main, 200);
        } catch (\Exception $e) {
            return response()->json('error', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Main::find($id)->delete();

        return response()->json('ok', 200);
    }

    public function whereTest(Request $request)
    {
        $mains = Main::where('type', $request->type)->get();


        return response()->json($mains, 200);

    }


}
