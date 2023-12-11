<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
     /**
     * @var Model
     */
    protected $model;

    /**
     * @param  Model $book
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    /**
     * @return Collection
     */
    public function index()
    {
        $items = $this->model->with('authors')->get();
        return response(['data' => $items, 'status' => 200]);
    }

    /**
     * @param  Request $request
     * @return Collection
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isbn' => 'required|digits:13|integer|unique:books,isbn',
            'name' => 'required|min:3',
            'year' => 'required|integer|digits:4',
            'page' => 'required|integer',
            'author_id' => 'exists:authors,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item = $this->model->create($request->all());

        $authorId = $request->input('author_id');
        $item->authors()->attach($authorId);

        return $this->index();
    }


    /**
     * @param  mixed $id
     * @return Collection
     */
    public function destroy($id)
    {
        try {
            $item = $this->model->with('authors')->findOrFail($id);
            $item->authors()->detach();
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
            $item = $this->model->with('authors')->findOrFail($id);
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
            $item = $this->model->with('authors')->findOrFail($id);
            $item->update($request->all());

            $authors = $request->get('authors');
            $item->authors()->sync($authors);

            // Retrieve the updated item with authors after sync
            $updatedItem = $this->model->with('authors')->findOrFail($id);

            return response(['data' => $updatedItem, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
    //
}
