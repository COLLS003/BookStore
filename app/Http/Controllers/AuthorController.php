<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;

class AuthorController extends Controller
{
    //
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param  Model $author
     * @return void
     */
    public function __construct(Author $author)
    {
        $this->model = $author;
    }

    /**
     * @return Collection
     */
    public function index()
    {
        $items = $this->model->with('books')->get();
        return response(['data' => $items], 200);
    }

    /**
     * @param  Request $request
     * @return Collection
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'firstname' => 'required',
        //     'lastname' => 'required',
        // ]);

        // $author = new Author;
        // $author->firstname = $request->firstname;
        // $author->lastname = $request->lastname;
        // $author->save();

        // // $this->model->create($request->all());
        // return response() ->json
        // (
        //     [
        //     "message"=>"auther  added successfuly",
        //     "Author"=>$author
        //     ],
        //     201
        // );
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $this->model->create($request->all());
        return $this->index();

    }

    /**
     * @param  mixed $id
     * @return Collection
     */
    public function destroy($id)
    {
        try {
            $item = $this->model->with('books')->findOrFail($id);
            $item->books()->detach();
            $item->delete();
            return $this->index();
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    /**
     * @param  mixed $id
     * @return Model
     */
    public function show($id)
    {
        try {
            $item = $this->model->with('books')->findOrFail($id);
            return response(['data' => $item, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    /**
     * @param  mixed $id
     * @param  mixed $request
     * @return Collection
     */
    public function update($id, Request $request)
    {
        try {
            $item = $this->model->with('books')->findOrFail($id);
            $item->update($request->all());
            return response(['data' => $item, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
}
