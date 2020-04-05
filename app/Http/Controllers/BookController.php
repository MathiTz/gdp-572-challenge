<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\Book as BookResource;
use App\Book;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BookCollection
     */
    public function index()
    {
        return new BookCollection(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return BookResource|ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $book = new Book();

        if (!$request->title) {
            return \response(['error' => 'Title cannot be empty'], 400, []);
        }

        $book->title = $request->title;

        $bookInStore = Book::where('title', $request->title)->first();

        if ($bookInStore) {
            return \response(['error' => 'Book is already in the store'], 400, []);
        } else {
            $book->unit = 1;
            $book->save();
            return new BookResource($book);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BookResource
     */
    public function show($id)
    {
        return new BookResource(Book::FindOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return BookResource|ResponseFactory|Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) return \response(['error' => "Book doesn't exist"], 400, []);

        if ($request->title) $book->title = $request->title;

        $bookCount = $book->unit;
        $bookCount++;

        $book->unit = $bookCount;

        $book->update();

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return BookResource|ResponseFactory|Response
     */
    public function destroy($id)
    {
        $book = Book::where('id', $id)->first();

        if (!$book) return \response(['error' => "Book doesn't exist"], 400, []);

        $book->delete();

        return \response(['success' => "Book deleted"], 200, []);
    }
}
