<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image',
            'status' => 'required|in:' . Product::PRODUCTO_NO_DISPONIBLE . ',' . Product::PRODUCTO_DISPONIBLE,
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        if ($request->status == Product::PRODUCTO_DISPONIBLE && $request->quantity > 0) {
            $data['status'] = Product::PRODUCTO_DISPONIBLE;
        } else {
            $data['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        }

        $data['image'] = $request->image->store('');

        $product = Product::create($data);

        return $this->showOne($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'quantity' => 'integer|min:0',
            'status' => 'in:' . Product::PRODUCTO_NO_DISPONIBLE . ',' . Product::PRODUCTO_DISPONIBLE,
            'price' => 'numeric|min:0',
            'image' => 'image',
        ];

        $this->validate($request, $rules);

        $product->fill($request->only([
            'name',
            'description',
            'status',
            'quantity',
            'price',
        ]));

        if ($request->hasFile('image')) {
            if ($this->NotFactoryImg($product->image)) {
                Storage::delete($product->image);
            }
            $product->image = $request->image->store('');
        }

        if ($product->isClean()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }
        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function destroy(Product $product)
    {
        if ($this->NotFactoryImg($product->image)) {
            Storage::delete($product->image);
        }
        $product->delete();
        return $product;
    }

    public function NotFactoryImg($image)
    {
        $factoryImg = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg');
        if (array_search($image, $factoryImg) === false) {
            return true;
        } else {
            return false;
        }
    }
}
