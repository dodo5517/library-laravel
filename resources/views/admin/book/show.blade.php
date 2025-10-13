@extends('admin_layout')
@section('content')
<?
    if($row['status']==0) { $status = '대출 불가능'; }
    elseif($row['status']==1) { $status = '대출 가능'; }
    elseif($row['status']==2) { $status = '예약중'; }
?>
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">도서 상세페이지</h1>
  <div class="card shadow mb-4">
        <!-- User Details -->
        <div class="card-body">
            <div class="detail">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th scope="row" class="text-gray-800">번호</th>
                    <td>{{ $row->id }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">제목</th>
                    <td>{{ $row->title }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">작가</th>
                    <td>{{ $row->author }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">카테고리</th>
                    <td>{{ $row->category_name }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">장르</th>
                    <td>{{ $row->genre }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">출판일자</th>
                    <td>{{ $row->published_date }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">줄거리</th>
                    <td class="summary">{{ $row->summary }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">도서상태</th>
                    <td>{{ $status }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-gray-800">사진</th>
                    <td><b>파일이름</b> :
                        @if($row->pic)
                            @php
                                $pic = json_decode($row->pic, true); 
                            @endphp
                            {{ $pic['title'] }}
                        @else
                            파일 없음
                        @endif
                        <br>
                    @if($row->pic)
                        <img src="{{ asset('/storage/product_img/'. $pic['path']) }}" width="200"
                            class="img-fluid img-thumbnail mymargin5">
                    @else
                        <img src=" " width="200" height="150" class="img-fluid img-thumbnail mymargin5">
                    @endif
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
            <div class="cardButtonDiv">
                <a href="{{ route('book.edit', $row->id) }}{{ $tmp }}"><button class="btn btn-primary">수정</button></a>
                <form action="{{ route('book.destroy', $row->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onClick="return confirm('삭제할까요 ?');">삭제</button>
                </form>
                <input type="button" value="뒤로가기" class="btn btn-secondary" onClick="history.back();">
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection