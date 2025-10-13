<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function wish(Request $request)
    {
        $client_id = $request->input('client_id');
        $book_id = $request->input('book_id');

        if(!$client_id){
            return redirect()->back()->with('error', '로그인 후 이용해 주세요.');
        }

        $duplicate = Wishlist::where('client_id', $client_id)
                    ->where('book_id', $book_id)
                    ->exists();
        if ($duplicate){
            return redirect()->back()->with('error', '이 책은 이미 찜한 도서입니다.');
        }
        
        // 찜
        Wishlist::create([
            'client_id' => $client_id,
            'book_id' => $book_id,
        ]);

        return redirect()->back()->with('success', '찜 성공!');
    }
}
