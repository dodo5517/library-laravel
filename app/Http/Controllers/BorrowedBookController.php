<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Client;
use App\Models\Book;


class BorrowedBookController extends Controller
{
    public function getlist($text1, $searchOption)
    {
        $query = BorrowedBook::join('books', 'borrowed_books.book_id', '=', 'books.id')
                    ->join('clients', 'borrowed_books.client_id', '=', 'clients.id')
                    ->select(
                        'borrowed_books.id',
                        'borrowed_books.client_id',
                        'borrowed_books.book_id',
                        'clients.clientName',
                        'books.title as bookTitle',
                        'borrowed_books.borrow_date',
                        'borrowed_books.due_date',
                        'borrowed_books.returned_date'
                    );

        // 검색 옵션에 따른 조건 추가
        if ($searchOption == 'book') {
            $query->where('books.title', 'like', '%' . $text1 . '%');
        } elseif ($searchOption == 'user') {
            $query->where('clients.clientName', 'like', '%' . $text1 . '%');
        }

        $result = $query->orderBy('borrowed_books.id', 'desc')
                    ->paginate(5)
                    ->appends(['text1' => $text1, 'searchOption' => $searchOption]);

        return $result;
    }

    public function qstring()
    {
        $text1 = request("text1") ? request("text1") : "";
        $searchOption = request("searchOption") ? request("searchOption") : "";
        $page = request('page') ? request('page') : "1";

        $tmp = "?text1=$text1&searchOption=$searchOption&page=$page";

        return $tmp;
    }

    public function index()
    {
        $data['tmp'] = $this->qstring();

        $text1 = request('text1');
        $searchOption = request('searchOption');
        $data['text1'] = $text1;
        $data['searchOption'] = $searchOption;

        $data['bookList'] = $this->getlist($text1, $searchOption);

        return view('admin.borrowedBook.index', $data);
    }   

    public function returnBook($id)
    {
        $borrowedBook = BorrowedBook::find($id);

        $borrowedBook->returned_date = now();
        $borrowedBook->save();
    
        return redirect()->route('admin.borrowedBook.index');
    }

}
