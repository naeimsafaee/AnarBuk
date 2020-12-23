<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Home;
use App\Http\Controllers\Controller;
use App\Query;
use App\Story;
use App\User;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stories = Story::where("Status", "1")->get();
        $res = array();
        $res["story"]["dataCount"] = count($stories);

        foreach ($stories as $story) {
            $book = $story->book;
            $book->author;
            $book->publisher;
            unset($story["BookID"]);
            unset($story["book"]["Opt"]);
            unset($story["book"]["CatID"]);
            unset($story["book"]["Year"]);
            unset($story["book"]["PublisherID"]);
            $res["story"]["data"][] = $story;
        }

        $homes = Query::where(["Status" => "1", "ForWhere" => "home"])->get();

        $i = 0;
        foreach ($homes as $home) {

            $res["data"][$i]["Title"] = $home["Title"];
            $res["data"][$i]["SpanCount"] = $home["SpanCount"];

            $books = Book::query();

            if ($home["Where"] != "") {
                $books = $books->Where($home["Where"], $home["WhereIsWhat"]);
            }
            if ($home["SortBy"] != "") {
                $books = $books->orderby(
                    $home["SortBy"],
                    $home["isSortDesc"] == 0 ? "asc" : "desc");
            }
            $books = $books->Limit($home["Limit"])->get();

            foreach ($books as $book) {
                $book->author;
                $book->publisher;
                unset($book["Opt"]);
                unset($book["CatID"]);
            }
            $res["data"][$i]["data"] = $books;
            $i++;
        }

        return response()->json($res, 200);
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
        //
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
