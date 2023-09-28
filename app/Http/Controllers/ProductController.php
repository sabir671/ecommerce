<?php

namespace App\Http\Controllers;

use App\Models\Catagorie;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        // dd($product->all());
        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // $product = DB::select('select * from  products ');
        $products = Catagorie::all();
        return view('backend.products.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
// dd($request->all());
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'category_id' => 'required', // Correct field name
            // Add more validation rules for other fields
        ]);

        // dd($validatedData['category_id']);
        $product = new Product();

        // Set the attributes with the validated data
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->discount = $validatedData['discount'];
        $product->catagory_id = $validatedData['category_id']; // Correct field name

        $product->save();


        // Redirect back to the index page or show a success message
        $products = Product::all(); // Change variable name to lowercase "products"
        return view('backend.products.index', compact('products'));


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::find($id);
        // dd($product);
        return view('backend.products.index',compact('products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $ValidatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'category_id' => 'required',
        ]);

        $product=Product::find($id);
        $product->name=$ValidatedData['name'];
        $product->price=$ValidatedData['price'];
        $product->discount=$ValidatedData['discount'];
        $product->catagory_id=$ValidatedData['category_id'];



        $product->save();
        return response()->json($product);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();
        return $this->index();
    }

}
