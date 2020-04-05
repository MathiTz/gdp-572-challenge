<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\RentedBook as RentedBookResource;
use App\Http\Resources\RentedBookCollection;
use App\RentedBook;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RentedBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RentedBookCollection
     */
    public function index()
    {
        return new RentedBookCollection(RentedBook::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RentedBookResource|ResponseFactory|Response
     * @throws Exception
     */
    public function store(Request $request)
    {
        $rent = new RentedBook();

        if (!$request->book_id) return \response(['error' => "Couldn't find book"], 400, []);

        $rent->book_id = $request->book_id;

        if (!$request->user_id) return \response(['error' => "Couldn't find user"], 400, []);

        $rent->user_id = $request->user_id;

        $book = Book::find($request->book_id, 'id')->first();

        if ($book->unit == 0) {
            return \response(['error' => "There're no copies left"], 400, []);
        }

        if ($request->payment_value) {
            $rent->payment_value = 'R$ '.$request->payment_value;
        } else {
            $rent->payment_value = 'R$ 3,50';
        }

        $date = new \DateTime('now');

        $rent->date_of_rent = $date;

        $interval = new \DateInterval('P3D');
        $date->add($interval);

        $rent->rent_expiration_date = $date->format('d-m-Y');

        $rent->status = 'ongoing';

        $countLessBook = $book->unit;
        $countLessBook--;

        $book->unit = $countLessBook;

        $book->update();

        $rent->save();

        return new RentedBookResource($rent);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RentedBook|Response
     */
    public function update(Request $request, $id)
    {
        $rent = RentedBook::find($id, 'id')->first();

        if ($rent->status === 'paid') return \response(['error' => "The book has already been paid"], 406, []);

        if (!$request->book_id) return \response(['error' => "Couldn't find the book"], 400, []);

        $book = Book::find($request->book_id, 'id')->first();
        $countPlusBook = $book->unit;
        $countPlusBook++;

        $book->unit = $countPlusBook;

        $book->update();

        $rent->status = 'paid';

        $rent->update();

        return \response(['success' => "Paid the rent successfully"], 201, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
