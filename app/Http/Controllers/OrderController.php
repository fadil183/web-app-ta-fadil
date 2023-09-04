<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
// use Illuminate\Support\Facades\Storage;
use Storage;


class OrderController extends Controller
{
    function __construct(){
        $this->middleware('permission:order-list|order-create|order-edit|order-delete',['only'=>['index','show']]);
        $this->middleware('permission:order-list|order-create|order-edit|order-delete',['only'=>['get','show']]);
        $this->middleware('permission:order-create',['only'=>['create','store']]);
        $this->middleware('permission:order-edit',['only'=>['edit','update']]);
        $this->middleware('permission:order-delete',['only'=>['destroy']]);
    }

    // menampilkan semua data order
    public function index(Request $request):View
    {
        if($request=null)
        {
            $orders=Order::where('id_order','LIKE', $request.'%')->paginate(10);
        }
        else
        {
            $orders=Order::latest()->paginate(10);
        }
        return view('orders.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    //menampilkan formulir untuk tambah order baru
    public function create():View{
        return view('orders.create');
    }
    //menyimpan data dari form tambah data
    public function store(Request $request):RedirectResponse{
        request()->validate([
            'id_order'=>'required|unique:orders,id_order|max:255',
            'image'=>'required'
        ]);
        //Image
        //mengatur gambar yang diambil dari webcam agar bisa disimpan kedalam storage
        $img=$request->image;
        $folderPath='images/';
        $image_parts=explode(";base64",$img);
        $image_type_aux= explode($folderPath, $image_parts[0]);
        $image_type=$image_type_aux[0];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName=uniqid().'.png';
        $file=$folderPath.$fileName;

        
        $request->request->add(['image_order' => $fileName]);
        
        if(!(Storage::disk('public_uploads')->put($file,$image_base64)&&Order::create($request->all()))) {
            return redirect()->route('orders.index')->with('Failed','Order created failed db or upload.');
        }
        return redirect()->route('orders.index')->with('Success','Order created successfuly.');
    }

    //menampilkan data order tertentu
    public function show(Order $order): View{
        return view('orders.show', compact('order'));
    }

    public function find(Request $request)
    {
        $query = $request->get('query');
        // $query = $request->query;

        if($request->ajax())
        {
            $data=Order::where('id_order','LIKE', $query.'%')
            ->limit(10)
            ->get();
            $output='';
            if(count($data)>0)
            {
                $output='<ul class="list-group">';
                foreach($data as $row)
                {
                    $output .='<li class="list-group-item">'.$row->id_order.'</li>';
                }
                $output.='</ul>';
            } else 
            {
                $output .='<li class="list-group-item">'. 'data tidak ada'.'</li>';
            }
            return $output;
        }
        $orders=$request;
        $user=Order::where('id_order', 'LIKE', '&'.$query.'%')
            ->simplePaginate(10);
            return view('orders.index', compact('orders'));
    }   
    public function displayImage($filename)
    {
    
        $path = storage_public('/' . $filename);
    
        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    }

    //menampilkan formulir ubah order tertentu
    public function edit(Order $order):view
    {
        return view('orders.edit', compact('order'));
    }

    //memperbarui data order pada penyimpanan
    public function update(Request $request, Order $order):RedirectResponse
    {
        //melakukan validasi untuk data yang dikirim apakah terdapat isinya atau tidak
        request()->validate([
            'id_order'=>'required|max:255',
        ]);
        //Image
        //cek apa ada perubahan gambar
        if($request->image!=null)
        {
            //mengatur gambar yang diambil dari webcam agar bisa disimpan kedalam storage
            $img=$request->image;
            $folderPath='images/';

            $image_parts=explode(";base64",$img);
            $image_type_aux= explode($folderPath, $image_parts[0]);
            $image_type=$image_type_aux[0];

            $image_base64 = base64_decode($image_parts[1]);
            $fileName=uniqid().'.png';
            $file=$folderPath.$fileName;
            //masukan nama gambar baru kedalam array untuk disimpan ke db
            $request->request->add(['order_image' => $fileName]);
            // upload gambar jika ada perubahan
            if(!Storage::disk('public_uploads')->put($file, $image_base64))
                {
                    return redirect()->route('orders.index')
                        ->with('Failed','Upload photo failed');
                }
            // hapus gambar terdahulu
            Storage::disk('public_uploads')->delete($folderPath.$request->saved_image_name);
        }
        if(!$order->update($request->all()))
            {
                return false;
            }
        return redirect()->route('orders.index')
            ->with('Success','Order updated successfully');
    }
    //menghapus data tertentu
    public function destroy(Order $order):RedirectResponse
    {
        Storage::disk('public_uploads')->delete('images/'.$order->order_image);
        $order->delete();
        return redirect()->route('orders.index')
            ->with('Success','Order deleted successfully');
    }

}
