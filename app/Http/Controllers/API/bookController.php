<?php

namespace App\Http\Controllers\API;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

use App\Book;
use App\Http\Controllers\Controller;
use App\Main;
use App\Story;
use App\User;
use App\user_views;
use Validator;
use Illuminate\Http\Request;

class bookController extends Controller
{
    private $messages = [
        'name.required' => 'name is required',
        'name.string' => 'name must be a string',
        'image.image' => 'image must be an image',
        'pubID.required' => 'pubID is required',
        'pubID.integer' => 'pubID must be an integer',
        'pubID.exists' => 'pubID doesn\'t exist',
        'year.integer' => 'year must be an integer',
        'catID.integer' => 'catID must be an integer',
        'catID.required' => 'catID is required',
        'catID.exists' => 'catID doesn\'t exist',
        'opt.string' => 'opt must be a string',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'string|required',
                'image' => 'image',
                'pubID' => 'integer|required|exists:App\Publisher,id',
                'year' => 'integer',
                'catID' => 'integer|required|exists:App\SubCategory,id',
                'opt' => 'string',
            ],
            $this->messages
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "responseCode" => 401,
                    "errorCode" => 'incomplete data',
                    'message' => $validator->errors(),
                ], 401);
        }

        $file_name = "";

        $color = "#ffffff";

        $file = $request->file('image');
        if ($file != null) {
            $ext = $file->extension();
            $file_name = time() . mt_rand() . "." . $ext;
            $file->move(public_path(
                'images/books/'
            ), $file_name);
            $color = Color::fromIntToHex((new ColorExtractor(
                Palette::fromFilename(
                    public_path('images/books/') . $file_name
                )))->extract(1)[0]);
        }

        Book::Create(
            [
                'BookID' => randomId(),
                'Name' => $request->name,
                'Image' => $file_name,
                'Color' => $color,
                'PublisherID' => $request->pubID,
                'Year' => $request->year,
                'CatID' => $request->catID,
                'Opt' => $request->opt,
            ]
        );

        return response()->json(["success" => ["message" => "new book created!"]], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, $add_view = false)
    {
        if (is_numeric($id))
            $book = Book::Where("id", $id)->get();
        else
            $book = Book::Where("BookID", $id)->get();

        if (count($book) == 0) {
            return response()->json(["message" => "not found!"], 404);
        }
        $book = $book[0];
        if ($add_view)
            Book::find($book["id"])->increment('View', 1);

        $book->bookInfo;
        $book->publisher;
        $book->author;
        $book->category;

        return response()->json(["data" => $book], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            $id = Book::Where("BookID", $id)->get("id");
            if (count($id) == 0)
                return response()->json(
                    [
                        "error" => ["message" => "book not found!"]
                    ], 404);

            $id = $id[0]["id"];
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'string|required',
                'image' => 'image|nullable',
                'pubID' => 'integer|required',
                'year' => 'integer|nullable',
                'catID' => 'integer|required',
                'opt' => 'string|nullable',
            ],
            $this->messages
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "responseCode" => 401,
                    "errorCode" => 'incomplete data',
                    'message' => $validator->errors(),

                ], 401);
        }

        $book = Book::find($id);
        if ($book == null)
            return response()->json(
                [
                    "error" => ["message" => "book not found!"]
                ], 404);

        $file = $request->file('image');
        if ($file != null) {
            $ext = $file->extension();
            $file_name = time() . mt_rand() . "." . $ext;
            $file->move(public_path(
                'images/books/'
            ), $file_name);
            $book->Image = $file_name;
        }

        $book->Name = $request->name;
        $book->PublisherID = $request->pubID;
        $book->Year = $request->year;
        $book->CatID = $request->catID;
        $book->Opt = $request->opt;
        $book->save();

        return response()->json(
            [
                "result" => [
                    "message" => "edited!"
                ]
            ], 200);
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

    public function add_view(Request $request)
    {
        $device_id = $request->device_id;
        $book_id = $request->id;
        if (!is_numeric($book_id))
            $book_id = Book::Where("BookID", $book_id)->get("id")->first()["id"];

        $id = User::Where("DeviceID", $device_id)->get("id")->first();
        if ($id == null)
            return response()->json(
                ["error" => ["message" => "device id not found!"]], 404);

        $views = $id->user_views;

        $has_viewed = false;
        foreach ($views as $view) {
            if ($view["BookID"] == $book_id)
                $has_viewed = true;
        }

        if (!$has_viewed) {
            user_views::Create(
                [
                    'BookID' => $book_id,
                    'UserID' => $id["id"],
                ]);
        }

        return $this->show($book_id, !$has_viewed);
    }

    /*public function search(Request $request)
    {
        $books = Book::where('Name', "like", "%" . $request->search . "%")
            ->orderby("View", 'DESC')->orderBy('Rating', 'DESC')->Paginate(10);

        $total = ;

        foreach ($books as $book) {
            $book->publisher;
            unset($book["PublisherID"]);
            unset($book["Opt"]);
            $book->author;
        }

        return response()->json($total, 200);
    }*/

}
