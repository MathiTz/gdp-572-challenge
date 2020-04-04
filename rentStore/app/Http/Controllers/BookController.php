<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\Book as BookResource;
use App\Book;
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
     * @return BookResource | bool
     */
    public function store(Request $request)
    {
        $book = new Book();
        $book->title = $request->title;

        $bookInStore = Book::where('title', $request->title)->firstOrFail();

        if ($bookInStore) {
          $countBookInStore = $bookInStore->unit;
          $countBookInStore++;

          $bookInStore->unit = $countBookInStore;
          $bookInStore->update();

          return new BookResource($bookInStore);

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
     * @return BookResource
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $book->title = $request->title;
        $book->unit = $book->unit++;

        $book->update();

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return BookResource
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return new BookResource($book);
    }
}
