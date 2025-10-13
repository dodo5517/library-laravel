<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\BorrowRequest;
use App\Models\Client;
use App\Models\Category;
use App\Models\Wishlist;
use Image;



class BookController extends Controller
{
    protected $totalLoanAvailable = 5;
    
    public function getlist($text1, $category_id = null, $searchOption = null)
    {
        // Book과 Category 테이블 조인
        $query = Book::join('categories', 'books.category_id', '=', 'categories.id')
            ->select('books.*', 'categories.name as category_name'); // 책 테이블의 모든 컬럼과 카테고리 이름 추가
        
        // category_id에 따른 필터링 조건 추가
        if ($category_id !== null) {
            $query->where('books.category_id', $category_id);
        }
    
        if($searchOption == 'all') {
            // 책 제목과 작가 모두 검색
            $query->where(function($query) use ($text1) {
                $query->where('books.title', 'like', '%' . $text1 . '%')
                    ->orWhere('books.author', 'like', '%' . $text1 . '%');
            });
        } elseif($searchOption == 'title') {
            $query->where('books.title', 'like', '%' . $text1 . '%');
        } elseif($searchOption == 'author') {
            $query->where('books.author', 'like', '%' . $text1 . '%');
        }
        
        // 결과 정렬 및 페이지네이션
        $result = $query->orderby('books.id')
            ->paginate(5)
            ->appends(['text1' => $text1]);
    
        return $result;
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
        $data['tmp']=$this->qstring();

        $text1=request('text1');
        $data['text1']=$text1;
        $data["list"]=$this->getlist($text1);

        return view('admin.book.index', $data); // 기본 index 페이지
    }

    public function searchList()
    {
        $data['tmp']=$this->qstring();

        $text1=request('text1');
        $searchOption=request('searchOption');

        $data['text1']=$text1;
        $data["searchOption"]=$searchOption;
        $data["list"]=$this->getlist($text1, null, $searchOption);

        return view('main.searchList', $data);
    }

    public function main_index($category_id)
    {
        $data['tmp']=$this->qstring();

        $text1=request('text1');
        $searchOption=request('searchOption');

        $data['text1']=$text1;
        $data["category_id"]=$category_id;
        $data['searchOption']=$searchOption;
        $data["list"]=$this->getlist($text1, $category_id, $searchOption);

        return view('main.book.main_index', $data); //view폴더 아래에 book안에 indexKorean 파일을 말하는 것임.
    }
    
    public function indexMyBook($id)
    {
        // 로그인 한 사용자 정보
        $data['client'] = Client::find($id);
        $data["totalLoanAvailable"] = $this->totalLoanAvailable;
    
        // 해당 사용자가 예약한 책들 조회
        $borrowRequestBooks = BorrowRequest::join('books', 'borrow_requests.book_id', '=', 'books.id')
            ->where('borrow_requests.status', 2)
            ->where('borrow_requests.client_id', $id)
            ->get(['borrow_requests.id', 'borrow_requests.book_id', 'books.title', 'borrow_requests.request_date', 'books.pic']);
            // 예약한 책들의 제목과 정보를 저장할 배열
        $borrowRequestBooksData = [];
        foreach ($borrowRequestBooks as $borrowRequestBook) {
            $borrowRequestBooksData[] = [
                'id' => $borrowRequestBook->id,
                'book_id' => $borrowRequestBook->book_id,
                'title' => $borrowRequestBook->title,
                'request_date' => $borrowRequestBook->request_date,
                'pic' => $borrowRequestBook->pic,
            ];
        }

        // 예약한 책들의 정보 추가
        $data['borrowRequestBooksData'] = $borrowRequestBooksData;

        // 해당 사용자가 대출한 책들 조회 (반납되지 않은 책만)
        $borrowedBooks = BorrowedBook::join('books', 'borrowed_books.book_id', '=', 'books.id')
            ->where('borrowed_books.client_id', $id)
            ->whereNull('borrowed_books.returned_date')
            ->get(['borrowed_books.book_id', 'books.title', 'borrowed_books.due_date', 'books.pic']);
    
        // 대출한 책들의 제목과 due_date, pic 정보를 저장할 배열
        $borrowedBooksData = [];
        foreach ($borrowedBooks as $borrowedBook) {
            $borrowedBooksData[] = [
                'book_id' => $borrowedBook->book_id,
                'title' => $borrowedBook->title,
                'due_date' => $borrowedBook->due_date,
                'pic' => $borrowedBook->pic,
            ];
        }
    
        // 대출한 책들의 정보 추가
        $data['borrowedBooksData'] = $borrowedBooksData;
    
        // 찜 목록 조회
        $wishlist = Wishlist::join('books', 'wishlists.book_id', '=', 'books.id')
            ->where('wishlists.client_id', $id)
            ->get(['wishlists.id', 'wishlists.book_id', 'books.title', 'books.author', 'books.status', 'books.pic']);
    
        // 찜 목록의 책 정보 저장
        $wishListData = [];
        foreach ($wishlist as $wishlistItem) {
            $wishListData[] = [
                'id' => $wishlistItem->id,
                'book_id' => $wishlistItem->book_id,
                'wishTitle' => $wishlistItem->title,
                'author' => $wishlistItem->author,
                'status' => $wishlistItem->status,
                'pic' => $wishlistItem->pic,
            ];
        }
    
        $data['wishlist'] = $wishListData;
    
        // 뷰에 전달
        return view('main.book.indexMyBook', $data);
    }
    

    public function adminBookIndex()
    {
        return view('main.admin.book.index');
    }
    
    public function save_row(Request $request, $row)
    {
        $request->validate([
            'title' => 'required|max:50',
            'author' => 'required|max:50',
        ], [
            'title.required' => '제목은 필수입력입니다.',
            'author.required' => '작가는 필수입력입니다.',
            'title.max' => '50자 이내입니다.',
            'author.max' => '50자 이내입니다.',
        ]);
    
        $row->title = $request->input('title');
        $row->author = $request->input('author');
        $row->category_id = $request->input('category_id');
        $row->genre = $request->input('genre');
        $row->published_date = $request->input('published_date');
        $row->summary = $request->input('summary');
        $row->status = $request->input('status');
    
        if ($request->hasFile('pic')) {
            // 파일 업로드 처리

            // 기존 파일이 있으면 삭제
            if ($row->pic) {
                $existingPic = json_decode($row->pic, true);  // JSON에서 파일 정보를 디코딩
                $existingPath = storage_path('app/public/product_img/' . $existingPic['path']);
                $existingThumb = storage_path('app/public/product_img/thumb/' . $existingPic['path']);

                if (file_exists($existingPath)) {
                    unlink($existingPath); // 기존 파일 삭제
                }

                if (file_exists($existingThumb)) {
                    unlink($existingThumb); // 썸네일 파일 삭제
                }
            }
 
            $pic = $request->file('pic');
            $originalName = $pic->getClientOriginalName();
            $randomName = Str::random(40) . '.' . $pic->getClientOriginalExtension();
            
            $pic->storeAs('public/product_img', $randomName);
            
            $img = Image::make($pic)
                ->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(storage_path('app/public/product_img/thumb/' . $randomName));
    
            // JSON 데이터로 저장
            $fileData = [
                'title' => $originalName, // 원본 파일명
                'path' => $randomName,    // 저장된 파일명
            ];
            $row->pic = json_encode($fileData);
        }

        $row->save();
    }

    public function delete_file($id)
    {
        $row = Book::find($id);

        if ($row->pic) {
            $fileData = json_decode($row->pic, true);  // JSON에서 파일 정보를 디코딩
            $existingPath = storage_path('app/public/product_img/' . $fileData['path']);
            $existingThumb = storage_path('app/public/product_img/thumb/' . $fileData['thumb']);

            if (file_exists($existingPath)) {
                unlink($existingPath); // 기존 파일 삭제
            }

            if (file_exists($existingThumb)) {
                unlink($existingThumb); // 썸네일 파일 삭제
            }
            $row->pic = "";
            $row->save();
        }

        $data['tmp'] = $this->qstring();
        return view('admin.book.edit', $data);
    }
        

    public function create()
    {
        $data['tmp']=$this->qstring();

        $data['categories'] = Category::all(); // 카테고리 목록

        return view('admin.book.create', $data);
    }

    public function store(Request $request)
    {
        $row = new Book;
        $this->save_row($request, $row);
        
        $tmp=$this->qstring();
        return redirect('book'. $tmp);
    }

    public function show($id)
    {
        $data['tmp'] = $this->qstring();
    
        // Book과 Category 조인하여 데이터 조회
        $data['row'] = Book::join('categories', 'books.category_id', '=', 'categories.id')
            ->where('books.id', $id)
            ->select('books.*', 'categories.name as category_name') // book의 모든 필드와 category_name 추가
            ->first(); // 단일 결과 반환
    
        return view('admin.book.show', $data);
    }

    public function edit($id)
    {
        $data['tmp'] = $this->qstring();
    
        // Book과 Category 조인하여 데이터 조회
        $data['row'] = Book::join('categories', 'books.category_id', '=', 'categories.id')
            ->where('books.id', $id)
            ->select('books.*', 'categories.name as category_name')
            ->first();
    
        // 모든 카테고리 가져오기
        $data['categories'] = Category::all(); // 카테고리 목록
    
        return view('admin.book.edit', $data);
    }
    

    public function update(Request $request, $id)
    {
        $row = Book::find($id);
        $this->save_row($request, $row);

        $tmp=$this->qstring();
        
        return redirect('book'. $tmp);
    }

    public function destroy($id)
    {
        Book::find($id)->delete();

        $tmp=$this->qstring();
        return redirect('book'. $tmp);
    }

    public function wishDestroy($id)
    {
        Wishlist::find($id)->delete();

        return redirect()->back();
    }

    public function requestCancel($id)
    {
        $requestBook = BorrowRequest::find($id);
        // "예약취소" 처리
        $requestBook->status = 3;
        $requestBook->request_date = now();
        $requestBook->save();

        $book = Book::find($requestBook->book_id);
        // "대출가능"
        $book->status = 1;
        $book->save();

        return redirect()->back();
    }

    public function detail($id)
    {
        $data['tmp']=$this->qstring();

        $data['row'] = Book::find($id);
        return view('main.book.detail', $data);
    }
}
?>