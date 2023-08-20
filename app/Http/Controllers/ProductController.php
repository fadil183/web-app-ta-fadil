<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
// use Storage;


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
    //menyimpan data dari form tambah data
    public function store(Request $request):RedirectResponse{
        request()->validate([
            'order_id'=>'required',
            'detail'=>'required',
            'image'=>'required',
        ]);
        //Image
        $img=$request->image;
        $folderPath="upload/";

        $image_parts=explode(";base64",$img);
        $image_type_aux= explode("upload/", $image_parts[0]);
        $image_type=$image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName=uniqid().'.png';
        $file=$folderPath.$fileName;
       


        //String
        //memasukan nama gambar kedalam order_image di array
        $request->request->add(['order_image' => $file]);
        // membuat data baru kedalam db
        $request->image->storeAs($image_base64, $fileName);
        Product::create($request->all());
        return redirect()->route('products.index')->with('Success','Product created successfuly. berserta gambar'.$fileName);
    }

    //menampilkan data product tertentu
    public function show(Product $product): View{
        $image = Storage::get($product->order_image);
        return view('products.show', compact('product'));
    }
    public function displayImage($filename)
    {
    
        $path = storage_public('upload/' . $filename);
    
        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
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
            'order_id'=>'required',
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
