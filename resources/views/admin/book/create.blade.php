@extends('admin_layout')
@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">도서 추가</h1>

    <form name="form1" method="post" action="{{ route('book.store') }}{{ $tmp }}"
        enctype="multipart/form-data">
	@csrf

        <div class="card shadow mb-4">
            <!-- User Details -->
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row" class="text-gray-800">번호</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">제목<font color="red">*</font></th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <input type="text" name="title" size="20" maxlength="20" value="" class="form-control form-control-sm">
                            </div>
                            @error('title') {{ $message }} @enderror
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">작가<font color="red">*</font></th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <input type="text" name="author" size="20" maxlength="20" value="" class="form-control form-control-sm">
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
                                        <option value="{{ $category->id }}">
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
                                <input type="text" name="genre" size="20" maxlength="20" value="" class="form-control form-control-sm">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">출판일자</th>
                        <td>
                            <div class="editInput d-inline-flex">
                            <input type="date" name="published_date" size="20" maxlength="20" value="" class="form-control form-control-sm">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">줄거리</th>
                        <td>
                            <div class="editInput d-inline-flex">
                            <textarea type="text" name="summary" size="255" maxlength="2000" class="form-control form-control-sm"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">도서상태</th>
                        <td>
                            <div class="editInput">
                                <input type="radio" name="status" value="0">&nbsp;대출 불가능
                                <input type="radio" name="status" value="1" checked>&nbsp;대출 가능&nbsp;&nbsp;
                                <input type="radio" name="status" value="2" >&nbsp;예약중&nbsp;&nbsp;
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-gray-800">사진</th>
                        <td>
                            <div class="editInput">
                                <input type="file" name="pic" value="" class="form-control form-control-sm">
                            </div>
                        </td>
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