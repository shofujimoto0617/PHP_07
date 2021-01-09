<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
/* save DBにデーターを登録③の場合必要 ↓↓ */
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /* Category AllCat(index) */
    public function AllCat(){

        /* DBからuserの値を直接取得(投稿順) ↓↓ */
        // $categories = DB::table('categories')
        //         ->join('users','categories.user_id','users.id')
        //         ->select('categories.*','users.name')
        //         ->latest()->paginate(5);

        /* Modelから値取得(投稿順) ↓↓ */
        $categories = Category::latest()->paginate(5);

        $trachCat = Category::onlyTrashed()->latest()->paginate(3);


        /* DBから値取得(投稿順) ↓↓ */
        // $categories = DB::table('categories')->latest->paginate(5);

        return view('admin.category.index', compact('categories','trachCat'));
    }

    /* Category AddCat(save) */
    public function AddCat(Request $request){

        /* validate */
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Less Then 255Chars',
            
        ]);

        /* Category Save ↓↓↓ (3 types) */

        /* DBにデーターを登録（方法①）*/
        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        /* DBにデーターを登録（方法②） */
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        /* DBにデーターを登録（方法③）*/
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success','Category Inserted Successfull');
    }

    /* Category AddCat(edit) */
    public function Edit($id){
        /* Modelから値取得（方法①） ↓↓ */
        // $categories = Category::find($id);

        /* DBから値取得（方法②） ↓↓ */
        $categories = DB::table('categories')->where('id',$id)->first();

        return view('admin.category.edit',compact('categories'));

    }

    /* Category AddCat(update) */
    public function Update(Request $request ,$id){

        /* ModelからUpdate（方法①) */
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id
        // ]);

        /* DBへ直接Update（方法②) */
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id',$id)->update($data);

        return Redirect()->route('all.category')->with('success','Category Updated Successfull');
    }

    /* 復元可能　削除 */
    public function SoftDelete($id){
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success','Category Soft Delete Successfully');
    }

    /* 削除データを復元 */
    public function Restore($id){
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success','Category Restore Successfully');
    }

    /* 復元不可　削除 */
    public function Pdelete($id){
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success','Category Permanently Deleted');

    }
}
