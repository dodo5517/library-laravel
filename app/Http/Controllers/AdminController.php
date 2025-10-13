<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MainController;

class AdminController extends Controller
{

    public function index(){
        $mainController = new MainController();
        $data["popularList"] = $mainController->popularBooks(5);

        if (session()->get("rank")!=1) return view('main.index');
        return view('admin.index', $data);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
