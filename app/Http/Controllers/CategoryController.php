<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //category create page
    public function list(){
        $categories = Category::when(request('searchKey'),function($query){
            $query->where('name','like','%'.request('searchKey').'%');

        })

        ->orderBy('created_at','desc')->paginate(5);

        $categoryCount = $categories->toArray();

        $categoryCount = count($categoryCount['data']);


        return view('admin.category.list',compact('categories','categoryCount'));
    }

    public function create( Request $request){
        $this->validationCheck($request);

       Category::create(['name'=>$request->categoryName]);

       return back()->with(['success' => 'create success']);


    }

    //delete category
    public function delete($id){
        Category::destroy($id);
        return back();
    }

    //edit category
    public function editPayment($id){
        $category = Category::find($id);

        return view('admin.category.edit',compact('category'));

    }

    //update category
    public function update($id,Request $request){
        $request['id'] = $id;
        $this->validationCheck($request);

       Category::where('id',$id)->update([
        'name' => $request->categoryName
       ]);

       return to_route('category#list');
    }


    //validation check for category

    private function validationCheck($request){

         $request->validate([
            'categoryName' => 'required|min:2|max:30|unique:categories,name,'.$request->id //self->skip|others->check
        ],[
            'categoryName.unique' => 'category name is already taken',
            'categoryName.min' => 'category name must have at least two letters'
        ]);

    }
}

