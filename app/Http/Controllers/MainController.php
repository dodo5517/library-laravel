<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BorrowRequest;
use App\Models\Book;
use Carbon\Carbon;


use App\Models\Wishlist;

class MainController extends Controller
{
    public function popularBooks($limit = 6){

        // 가장 많이 wishlist에 등록된 4개의 book_id를 가져오고, 해당 book 데이터 조회
        $popularBooks = Wishlist::join('books', 'wishlists.book_id', '=', 'books.id')
        ->select('books.*', DB::raw('COUNT(wishlists.book_id) as wishlist_count'))
        ->groupBy('books.id', 'books.title', 'books.author', 'books.genre', 'books.published_date', 'books.pic', 'books.status', 'books.category_id', 'books.created_at', 'books.updated_at', 'summary') // book_id 기준으로 그룹화
        ->orderBy('wishlist_count', 'desc') // 등록 횟수 내림차순 정렬
        ->limit($limit) // 상위 $limit 개만 선택
        ->get();

        return $popularBooks;    
    }
    public function index()
    {
        $data["popularList"]=$this->popularBooks();

        $overdueBooks = BorrowRequest::where('status', 2) // "예약중"인 요청 중에서
            ->where('request_date', '<', Carbon::now()->subDays(4)) // 현재 날짜에서 4일을 뺀 날짜보다 이전인 요청
            ->get();
        
        // 각 overdueBook에 대해 처리
        foreach ($overdueBooks as $overdueBook) {
            // "예약취소" 상태로 변경
            $overdueBook->status = 3; 
            $overdueBook->save();

            // 해당 도서의 상태를 "대출 가능"으로 변경
            $book = Book::find($overdueBook->book_id);
            if ($book) {
                $book->status = 1; // "대출 가능"
                $book->save();
            }
        }

        return view('main.index', $data); // 기본 index 페이지
    }
}
