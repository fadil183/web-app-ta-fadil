<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    
    function __construct(){
        $this->middleware('permission:product-list|product-create|product-edit|product-delete',['only'=>['index','show']]);
        $this->middleware('permission:product-create',['only'=>['create','store']]);
        $this->middleware('permission:product-edit',['only'=>['edit','update']]);
        $this->middleware('permission:product-delete',['only'=>['destroy']]);
    }

    // menampilkan semua data product
    public function index():View
    {
        $products=Product::latest()->paginate(5);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    //menampilkan formulir untuk tambah produk baru
    public function create():View{
        return view('products.create');
    }

    public function store(Request $request):RedirectResponse{
        request()->validate([
            'name'=>'required',
            'detail'=>'required',
        ]);
        Product::create($request->all());

        return redirect()->route('products.index')->with('Success','Product created successfuly.');
    }

    //menampilkan data product tertentu
    public function show(Product $product): View{
        return view('products.show', compact('product'));
    }

    //menampilkan formulir ubah product tertentu
    public function edit(Product $product):view
    {
        return view('products.edit', compact('product'));
    }

    //memperbarui data product pada penyimpanan
    public function update(Request $request, Product $product):RedirectResponses
    {
        //melakukan validasi untuk data yang dikirim apakah terdapat isinya atau tidak
        request()->validate([
            'name'=>'required',
            'detail'=>'required',
        ]);
        $products->update($request->all());
        return redirect()->route('products.index')
            ->with('Success','Product updated successfully');
    }
    //menghapus data tertentu
    public function destroy(Product $product):RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('Success','Product deleted successfully');
    }

}
