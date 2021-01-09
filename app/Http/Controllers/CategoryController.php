<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
//* save DBにデーターを登録③の場合必要 ↓↓
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //* Category AllCat(index)
    public function AllCat(){

        //* DBからuserの値を直接取得(投稿順) ↓↓
        // $categories = DB::table('categories')
        //         ->join('users','categories.user_id','users.id')
        //         ->select('categories.*','users.name')
        //         ->latest()->paginate(5);

        //* Modelから値取得(投稿順) ↓↓
        $categories = Category::latest()->paginate(5);

        //* DBから値取得(投稿順) ↓↓
        // $categories = DB::table('categories')->latest->paginate(5);

        return view('admin.category.index', compact('categories'));
    }

    //* Category AddCat(save)
    public function AddCat(Request $request){

        //* validate
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Less Then 255Chars',
            
        ]);

        //* Category Save ↓↓↓ (3 types)

        //* DBにデーターを登録（方法①）
        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        //* DBにデーターを登録（方法②）
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        //* DBにデーターを登録（方法③）
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success','Category Inserted Successfull');
    }


    public function Edit($id){
        $categories = Category::find($id);
        return view('admin.category.edit',compact('categories'));

    }

    public function Update(Request $request ,$id){
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);
        return Redirect()->route('all.category')->with('success','Category Updated Successfull');
    }
}
