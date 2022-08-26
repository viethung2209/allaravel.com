<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        //
//        $products = (DB::table('products')->get()) ;

        $products = DB::table('products')->paginate(5);
        return view('fontend.product.list', ['products' => $products])->render();
//        return view('fontend.product.list')->with($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        //
        return view('fontend.product.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'content' => 'required',
            'image_path' => 'max:255'
        ]);
        if ($validator->fails()) {
            return redirect('product/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // Lưu thông tin vào database, phần này sẽ giới thiệu ở bài về database
            $active = $request->has('active') ? 1 : 0;
            $product_id = DB::table('products')->insertGetId([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'content' => $request->input('content'),
                    'image_path' => $request->input('image_path'),
                    'active' => $active]
            );
            return redirect('product/')
                ->with('message', 'Sản phẩm được tạo thành công với ID: ' . $product_id);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        //
        $product = DB::table('products')->find($id);
        return view('fontend.product.edit')->with(compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //
        $active = $request->has('active')? 1 : 0;
        DB::table('products')
            ->where('id', '=', $id)
            ->update([
                'name'       => $request->input('name'),
                'price'      => $request->input('price'),
                'content'    => $request->input('content'),
                'image_path' => $request->input('image_path'),
                'active'     => $active,
                'updated_at' => Carbon::now()
            ]);

        return redirect('/product/')
            ->with('message', 'Cập nhật sản phẩm thành công');

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
