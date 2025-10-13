<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Controllers\MainController;

class ClientController extends Controller
{   
    public function getlist($text1){
        $result = Client::where('clientName','like','%'.$text1.'%')
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

        return view('admin.client.index', $data);
    }

    public function save_row(Request $request, $row)
    {
        $request->validate([
            'clientName'=>'required|max:20',
            'password'=>'required|max:20',
        ],
        [
            'clientName.required'=>'아이디는 필수입력입니다.',
            'password.required'=>'암호는 필수입력입니다.',
            'clientName.max'=>'20자 이내입니다.',
            'password.max'=>'20자 이내입니다.',
        ]);

        $tel1 = $request -> input("tel1");
        $tel2 = $request -> input("tel2");
        $tel3 = $request -> input("tel3");
        $tel = sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3);
        
        $row->clientName = $request->input('clientName');
        $row->password = $request->input('password');
        $row->tel = $tel;
        $row->email = $request->input('email');
        $row->rank = $request->input('rank');

        $row->save();
    }

    public function check(){
        $clientName = request('clientName');
        $password = request('password');

        $row = Client::where('clientName','=',$clientName)->where('password','=',$password)->first();
        if($row){ //있는 경우
            session()->put('id', $row->id);
            session()->put('clientName',$row->clientName); //세션으로 저장
            session()->put('rank',$row->rank);
        }

        $mainController = new MainController();
        $data["popularList"] = $mainController->popularBooks();

        return view("main.index", $data);
    }

    public function logout(){
        session()->forget('id');
        session()->forget('clientName');
        session()->forget('rank');

        $mainController = new MainController();
        $data["popularList"] = $mainController->popularBooks();

        return view("main.index", $data);
    }

    public function create()
    {
        $data['tmp']=$this->qstring();

        return view('admin.client.create', $data);
    }

    public function store(Request $request)
    {
        $row = new Client;
        $this->save_row($request, $row);
        
        $tmp=$this->qstring();
        return redirect('client'. $tmp);
    }

    public function show($id)
    {
        $data['tmp']=$this->qstring();

        //Eloquent ORM
        $data['row'] = Client::find($id);
        return view('admin.client.show', $data);
    }

    public function edit($id)
    {
        $data['tmp']=$this->qstring();

        $data['row']=Client::find($id);
        return view('admin.client.edit  ', $data);
    }

    public function update(Request $request, $id)
    {
        $row = Client::find($id);
        $this->save_row($request, $row);
        
        $tmp=$this->qstring();
        
        return redirect('client'. $tmp);
    }

    public function destroy($id)
    {
        Client::find($id)->delete();

        $tmp=$this->qstring();
        return redirect('client'. $tmp);
    }
}
