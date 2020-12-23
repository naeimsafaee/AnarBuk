<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\BookInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class bookInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_numeric($id))
            $id = Book::Where("BookID", $id)->get("id")[0]["id"];

        $book_info = BookInfo::Where("BookID", $id)->get();

        if (count($book_info) == 0) {
            return response()->json(["message" => "not found!"], 404);
        }

        foreach ($book_info as $item) {
            $item->translator;
            $item->customer;
        }

        return response()->json(["data" => $book_info], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
