<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $category = isset($data['category']) ? $data['category'] : null;
            $filter = isset($data['filter']) ? $data['filter'] : null;
            $keyword = isset($data['keyword']) ? $data['keyword'] : null;
            $fields = isset($data['fields']) ? $data['fields'] : [];

            $query = new Product();

            if ($filter && Schema::hasColumn($query->getTable(), $filter)) {
                $query = $query->where($filter, 'like', "%{$keyword}%");
            } else {
                if (count($fields) > 0) {
                    $query = $query->where(function ($q) use ($keyword, $fields) {
                        $q = $q->where($fields[0], 'like', "%{$keyword}%");

                        for ($i = 1; $i < count($fields); $i++) {
                            $q = $q->orWhere($fields[$i], 'like', "%{$keyword}%");
                        }
                    });
                }
            }

            if ($category) {
                $query = $query->where('category', '=', $category);
            }

            $query = $query->orderBy('name', 'ASC');

            return $query->paginate(5);
        } else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
