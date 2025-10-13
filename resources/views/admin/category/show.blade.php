@extends('admin_layout')
@section('content')
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">카테고리 상세페이지</h1>
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
                    <th scope="row" class="text-gray-800">이름</th>
                    <td>{{ $row->name }}</td>
                </tr>
                </tbody>
            </table>
            </div>
            <div class="cardButtonDiv">
                <a href="{{ route('category.edit', $row->id) }}{{ $tmp }}"><button class="btn btn-primary">수정</button></a>
                <form action="{{ route('category.destroy', $row->id) }}" method="POST">
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