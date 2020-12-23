<?php

namespace App\Http\Controllers\API;

use App\Author;
use App\Book;
use App\Http\Controllers\Controller;
use App\Publisher;
use App\Query;
use App\Translator;
use Illuminate\Http\Request;

class searchController extends Controller
{

    public function global_search(Request $request)
    {
        //search in books
        $books = Book::where('Name', "like", "%" . $request->search . "%")
            ->orderby("View", 'DESC')->orderBy('Rate', 'DESC');

        $total = $books->count();
        $books = $books->Limit(9)->get();

        $books = $books->sortByDesc("view_and_rate")->values()->all();

        foreach ($books as $book) {
            $book->publisher;
            $book->author;
            unset($book["PublisherID"]);
            unset($book["Opt"]);
        }
        $books_results = [
            "data_count" => count($books),
            "total_count" => $total,
            "span_count" => 3,
            "data" => $books
        ];

        $publishers = Publisher::where('Name', "like", "%" . $request->search . "%");

        $total = $publishers->count();
        $publishers = $publishers->Limit(6)->get();

        $publishers_results = [
            "data_count" => count($publishers),
            "total_count" => $total,
            "span_count" => 2,
            "data" => $publishers
        ];

        $translators = Translator::where('Name', "like", "%" . $request->search . "%");

        $total = $translators->count();
        $translators = $translators->Limit(6)->get();

        $translators_results = [
            "data_count" => count($translators),
            "total_count" => $total,
            "span_count" => 3,
            "data" => $translators
        ];

        $authors = Author::where('Name', "like", "%" . $request->search . "%");

        $total = $authors->count();
        $authors = $authors->Limit(6)->get();

        $authors_results = [
            "data_count" => count($authors),
            "total_count" => $total,
            "span_count" => 3,
            "data" => $authors
        ];

        $main_result["books"] = $books_results;
        $main_result["publishers"] = $publishers_results;
        $main_result["authors"] = $authors_results;
        $main_result["translators"] = $translators_results;

        return response()->json($main_result, 200);
    }

    public function search_book(Request $request)
    {
        $books = Book::where('Name', "like", "%" . $request->search . "%")
            ->orderby("View", 'DESC')->orderBy('Rate', 'DESC')->Paginate(10);

        $collection = $books->getCollection();

        $collection = $collection->sortByDesc("view_and_rate")->values()->all();

        foreach ($books as $book) {
            $book->publisher;
            unset($book["PublisherID"]);
            unset($book["Opt"]);
            $book->author;
        }

        return response()->json([
            "data_count" => count($collection),
            "current_page" => (int)$request->page,
            "total_count" => $books->total(),
            "data" => $collection
        ], 200);
    }

    public function top_search(Request $request)
    {
        $res = array();

        $homes = Query::where(["Status" => "1", "ForWhere" => "top_search"])->get();

        $res["data_count"] = count($homes);
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

        return response()->json($res , 200);
    }
}

