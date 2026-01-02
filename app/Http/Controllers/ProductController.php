<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //product list page
    public function list()
    {
        $products = Product::select('id', 'name', 'image', 'stock', 'created_at')->paginate(3);

        return view('admin.product.list', compact('products'));
    }
    //product create page
    public function createPage()
    {
        $categories = Category::select('id', 'name')->orderBy('created_at', 'desc')->get();

        return view('admin.product.create', compact('categories'));
    }

    //create product
    public function create(Request $request)
    {
        $this->productValidation($request, "create");

        $data = $this->getProductData($request);

        $file      = $request->image;
        $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
        $request->image->move(public_path('productImage/'), $imageName); //store in project

        $data['image'] = $imageName;

        Product::create($data);

        return back()->with(['success' => 'created successfully']);
    }

    //delete product
    public function delete($id)
    {
        //Product::destory($id); //delete from db

        $deleteImage = Product::find($id);
        $deleteImage = $deleteImage['image'];
        if (file_exists(public_path('productImage/' . $deleteImage))) {
            unlink(public_path('productImage/' . $deleteImage));
        }
        Product::destroy($id); // delete from db

        return to_route('product#list');
    }

    //product edit
    public function edit($id)
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $product    = Product::find($id);

        if (! file_exists(public_path('productImage/' . $product->image))) {
            $product->image = null;
        }
        return view('admin.product.edit', compact('product', 'categories'));
    }

    //product update
    public function update(Request $request, $id)
    {
        $request['id'] = $id;
        $this->productValidation($request, "update");

        $updateData = $this->getProductData($request);

        $product        = Product::find($id);
        $dbProductImage = $product->image;

        if ($request->hasFile('image')) {
            //old image delete -> new image store -> new image name db update
            $oldImage = $request['oldImageName'];

            if (file_exists(public_path('productImage/' . $oldImage)) && $dbProductImage !== null) {

                unlink(public_path('productImage/' . $oldImage));
            }

            $newImage = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('productImage/'), $newImage);

            $updateData['image'] = $newImage;

        }

        Product::find($id)->update($updateData);

        return to_route('product#list');

    }

    //get product data
    private function getProductData($request)
    {
        return [
            'name'        => $request->title,
            'price'       => $request->price,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'stock'       => $request->stock,
        ];
    }

    //validation check
    private function productValidation($request, $action)
    {

        $rules = [

            'title'       => 'required|min:3|max:100|unique:products,name,' . $request->id,
            'description' => 'required|min:10',
            'price'       => 'required|min:2|integer',
            'categoryId'  => 'required',
            'stock'       => 'required|integer|min:1',
        ];

        $rules['image'] = $action == 'create' ? 'required|image|mimes:jpg,jpeg,webp,svg,gif,png' : 'image|mimes:jpg,jpeg,webp,svg,gif,png';

        $message = [
            'image.required' => 'Image required!',
        ];

        $request->validate($rules, $message);
    }
}
