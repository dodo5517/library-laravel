<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Client;
use App\Models\BorrowedBook;
use App\Models\BorrowRequest;

class BorrowRequestController extends Controller
{
    public function getlist($text1, $serchOption)
    {
        $borrowRequests = BorrowRequest::join('clients', 'borrow_requests.client_id', '=', 'clients.id')
            ->join('books', 'borrow_requests.book_id', '=', 'books.id')
            ->select(
                'borrow_requests.id',
                'borrow_requests.client_id',
                'borrow_requests.book_id',
                'clients.clientName',
                'books.title as bookTitle',
                'borrow_requests.request_date',
                'borrow_requests.status'
            )
            ->orderBy('borrow_requests.id', 'desc')
            ->when($text1, function ($query) use ($text1) {
                // 검색어가 있을 경우, book 또는 client 이름으로 검색
                return $query->where(function ($query) use ($text1) {
                    $query->where('books.title', 'like', "%$text1%")
                        ->orWhere('clients.clientName', 'like', "%$text1%");
                });
            })
            ->paginate(7)
            ->appends(['text1' => $text1]); // 페이지네이션을 위한 텍스트 추가

        return $borrowRequests;
    }

    public function qstring()
    {
        $text1 = request("text1") ? request("text1") : "";
        $page = request('page') ? request('page') : "1";

        $tmp = $text1 ? "?text1=$text1&page=$page" : "?page=$page";

        return $tmp;
    }

    public function index()
    {
        $data['tmp'] = $this->qstring();
    
        $text1 = request('text1');
        $searchOption = request('searchOption');
        $data['text1'] = $text1;
        $data['searchOption'] = $searchOption;

        $borrowRequests = $this->getlist($text1, $searchOption);
    
        $data['log'] = $borrowRequests;
    
        return view('admin.log.index', $data);
    }

    

    private function createBookRequest($client_id, $book_id, $status)
    {
        BorrowRequest::create([
            'client_id' => $client_id,
            'book_id' => $book_id,
            'request_date' => now(),
            'status' => $status,
        ]);
    }

    // 책 대출(예약) 신청 기능
    public function borrowBookRequest(Request $request)
    {
        $client_id = $request->input('client_id');
        $book_id = $request->input('book_id');

        if (!$client_id) {
            return redirect()->back()->with('error', '로그인 후 이용해 주세요.');
        }

        // 1. 책 대출 가능 여부 확인 (status = 1)
        $book = Book::find($book_id);
        if (!$book || $book->status != 1) {
            $this->createBookRequest($client_id, $book_id, 0);
            return redirect()->back()->with('error', '이 책은 대출중입니다. 다음에 빌려주세요.');
        }

        // 2. 해당 사용자가 5권 이하로 빌렸는지 확인
        $borrowedBooksCount = BorrowedBook::where('client_id', $client_id)
            ->whereNull('returned_date') // 반납되지 않은 책만 포함
            ->count();
        if ($borrowedBooksCount > 5) {
            $this->createBookRequest($client_id, $book_id, 0);
            return redirect()->back()->with('error', '총 5권 대출할 수 있습니다. 반납 후 대출해주세요.');
        }

        // 3. 해당 사용자가 연체된 책이 있는지 확인 (due_date가 현재 날짜보다 작은 경우)
        $overdueBooks = BorrowedBook::where('client_id', $client_id)
            ->whereNull('returned_date') // 반납되지 않은 책만 확인
            ->where('due_date', '<', now()) // 마감일이 현재 날짜를 지난 경우
            ->exists();
        if ($overdueBooks) {
            $this->createBookRequest($client_id, $book_id, 0);
            return redirect()->back()->with('error', '연체된 책이 있습니다. 반납 후 대출해주세요.');
        }

        // 책 상태를 "예약중"으로 업데이트
        $book->status = 2;
        $book->save();

        $this->createBookRequest($client_id, $book_id, 2);

        // 성공 시 특정 뷰로 리다이렉트
        return redirect()->back()->with('success', '성공적으로 예약되었습니다. 3일 안에 도서를 대출해주세요.');
    }
    
    // 대출 승인 기능
    public function borrowRequestApprove($id){
        $requestBook = BorrowRequest::find($id);
        // request 테이블에서 도서 상태를 "대출중"으로
        $requestBook->status = 1;
        // 도서 대출 신청 시간을 갱신
        $requestBook->request_date = now();
        $requestBook->save();

        // 도서 대출 처리
        BorrowedBook::create([
            'client_id' => $requestBook->client_id,
            'book_id' => $requestBook->book_id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(7), // 7일 후 마감일 설정
        ]);

        // book 테이블에서 도서 상태를 "대출중"으로
        $book = Book::find($requestBook->book_id);
        $book->status = 1;
        $book->save();

        $data['tmp']=$this->qstring();

        $text1 = request('text1');
        $searchOption = request('searchOption');
        $data['text1'] = $text1;
        $data['searchOption'] = $searchOption;

        $borrowRequests = $this->getlist($text1, $searchOption);
    
        $data['log'] = $borrowRequests;
    
        return view('admin.log.index', $data);
    }
}
