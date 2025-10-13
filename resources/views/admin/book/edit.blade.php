@extends('admin_layout')
@section('content')
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">도서 수정</h1>

    <form name="form1" method="post" action="{{ route('book.update', $row->id) }}{{ $tmp }}"
        enctype="multipart/form-data">
	@csrf
	@method('PATCH')
        <div class="card shadow mb-4">
            <!-- User Details -->
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row" class="text-gray-800">번호</th>
                        <td>{{ $row->id }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">제목<font color="red">*</font></th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <input type="text" name="title" size="20" maxlength="20" value="{{ $row->title }}" class="form-control form-control-sm">
                            </div>
                            @error('title') {{ $message }} @enderror
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">작가<font color="red">*</font></th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <input type="text" name="author" size="20" maxlength="20" value="{{ $row->author }}" class="form-control form-control-sm">
                            </div>
                            @error('author') {{ $message }} @enderror
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">카테고리<font color="red">*</font></th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <select name="category_id" class="form-control form-control-sm">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ $row->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">장르</th>
                        <td>
                        <div class="editInput d-inline-flex">
                                <input type="text" name="genre" size="20" maxlength="20" value="{{ $row->genre }}" class="form-control form-control-sm">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">출판일자</th>
                        <td>
                            <div class="editInput d-inline-flex">
                            <input type="date" name="published_date" size="20" maxlength="20" value="{{ $row->published_date }}" class="form-control form-control-sm">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">줄거리</th>
                        <td>
                            <div class="editInput d-inline-flex">
                            <textarea type="text" name="summary" size="255" maxlength="2000" class="form-control form-control-sm">{{ $row->summary }}</textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">도서상태</th>
                        <td>
                            <div class="editInput">
                        @if($row->status==0)
                            <input type="radio" name="status" value="0" checked>&nbsp;대출 불가능
                            <input type="radio" name="status" value="1" >&nbsp;대출 가능&nbsp;&nbsp;
                            <input type="radio" name="status" value="2" >&nbsp;예약중&nbsp;&nbsp;
                        @elseif($row->status==1)
                            <input type="radio" name="status" value="0" >&nbsp;대출 불가능
                            <input type="radio" name="status" value="1" checked>&nbsp;대출 가능&nbsp;&nbsp;
                            <input type="radio" name="status" value="2" >&nbsp;예약중&nbsp;&nbsp;
                        @elseif($row->status==2)
                            <input type="radio" name="status" value="0" >&nbsp;대출 불가능
                            <input type="radio" name="status" value="1" >&nbsp;대출 가능&nbsp;&nbsp;
                            <input type="radio" name="status" value="2" checked>&nbsp;예약중&nbsp;&nbsp;
                        @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">사진</th>
                        <td>
                            <div class="d-inline-flex">
                                <input type="file" name="pic" size="20" value="{{ $row->pic }}" class="form-control form-control-sm">
                            </div>
                            <br><br>
                            @if($row->pic)
                                @php
                                    $fileData = json_decode($row->pic, true);
                                @endphp
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <b>파일이름</b>: {{ $fileData['title'] ?? '없음' }}
                                    </div>
                                </div>
                                <img src="{{ asset('/storage/product_img/thumb/'. ($fileData['path'] ?? '')) }}" width="200"
                                    class="img-fluid img-thumbnail mymargin5">
                            @endif
                    </tr>
                    </tbody>
                </table>
                <div class="cardButtonDiv">
                    <input type="submit" value="저장" class="btn btn-primary">
                    <input type="button" value="뒤로가기" class="btn btn-secondary" onClick="history.back();">
                </div>
            </div>
        </div>
    </form>
@endsection