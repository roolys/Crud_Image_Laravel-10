<?php


namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('index',compact('products'))
        ->with('i',(request()->input('page',1)-1)*5);
        //
        // return view('product.index',compact('products'));
        // return view('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'detail'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        //
        $input=$request->all();
        if($image=$request->file('image')){
            $destinationPath='images/';
            $profileImage=date('ymdHis').",".$image->getClientOriginalExtension();
            $image->move($destinationPath,$profileImage);
            $input['image']="$profileImage";
        }
        Product::create($input);
        return redirect('/product')->with('success','Product created successfully');
        // return redirect()->route('index')
        //                 ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
        return view('show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        //
        return view('edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        //
        $request->validate([
            'name'=>'required',
            'detail'=>'required',
        ]);

        $input=$request->all();

        if($image=$request->file('image')){
            $destinationPath='images/';
            $profileImage=date('ymdHis').",".$image->getClientOriginalExtension();
            $image->move($destinationPath,$profileImage);
            $input['image']="$profileImage";
        }else{
            unset($input['image']);
        }
        $product->update($input);
        return redirect('/product')->with('success','Product updated successfully');




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        //
        $product->delete();
        return redirect('/product')->with('success','Product deleted successfully');


    }
}
