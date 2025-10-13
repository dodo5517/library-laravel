@extends('admin_layout')
@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">카테고리 추가</h1>

    <form name="form1" method="post" action="{{ route('category.store') }}{{ $tmp }}">
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
                        <th scope="row" class="text-gray-800">이름<font color="red">*</font></th>
                        <td>
                            <div class="editInput d-inline-flex">
                                <input type="text" name="name" size="20" maxlength="20" value="" class="form-control form-control-sm">
                            </div>
                            @error('name') {{ $message }} @enderror
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="cardButtonDiv">
                    <input type="submit" value="저장" class="btn btn-primary">
                    <input type="button" value="뒤로가기" class="btn btn-secondary">
                </div>
            </div>
        </div>
    </form>
@endsection