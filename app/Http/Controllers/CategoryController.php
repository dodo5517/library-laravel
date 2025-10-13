<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function getlist($text1){
        $result = Category::where('name','like','%'.$text1.'%')
                    ->orderby('id')->paginate(5)->appends( ['text1'=>$text1] );
        return $result;
    }

    public function qstring()
    {
        $text1 = request("text1") ? request("text1") : "";
        $page = request('page') ? request('page') : "1";

        $tmp = $text1 ? "?text1=$text1&page=$page" : "?page=$page";

        return $tmp;
    }

    public function index(){

        $data['tmp']=$this->qstring();

        $text1=request('text1');
        $data['text1']=$text1;
        $data["list"]=$this->getlist($text1);

        return view('admin.category.index', $data);
    }

    public function save_row(Request $request, $row)
    {
        $request->validate([
            'name'=>'required|max:20',
        ],
        [
            'name.required'=>'이름은 필수입력입니다.',
            'name.max'=>'20자 이내입니다.',
        ]);
        
        $row->name = $request->input('name');

        $row->save();
    }

    public function create()
    {
        $data['tmp']=$this->qstring();

        return view('admin.category.create', $data);
    }

    public function store(Request $request)
    {
        $row = new Category;
        $this->save_row($request, $row);
        
        $tmp=$this->qstring();
        return redirect('category'. $tmp);
    }

    public function show($id)
    {
        $data['tmp']=$this->qstring();

        //Eloquent ORM
        $data['row'] = Category::find($id);
        return view('admin.category.show', $data);
    }

    public function edit($id)
    {
        $data['tmp']=$this->qstring();

        $data['row']=Category::find($id);
        return view('admin.category.edit  ', $data);
    }

    public function update(Request $request, $id)
    {
        $row = Category::find($id);
        $this->save_row($request, $row);
        
        $tmp=$this->qstring();
        
        return redirect('category'. $tmp);
    }

    public function destroy($id)
    {
        Category::find($id)->delete();

        $tmp=$this->qstring();
        return redirect('category'. $tmp);
    }
}   
