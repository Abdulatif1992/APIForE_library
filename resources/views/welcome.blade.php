@extends('dashboard')

@section('content')
<div class="container-fluid">
    @if(isset($books))
    <div class="alert alert-info">
        <strong>Create</strong> new book.
        <a href = "{{ route('newbook') }}" type="button" class="btn btn-success">Create</a>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('List of books') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(isset($books))
                        <table class='table table-bordered'>
                            <thead>
                            <tr>
                                <th class="col-md-1">Book Id</th>
                                <th class="col-md-8" colspan="2">Name / Title</th>
                                <th class="col-md-2">Image</th>
                                <th class="col-md-1">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td rowspan="2">{{$book->book_id}}</td>
                                    <td colspan="2"><b>{{$book->book_name}}</b></td>
                                    <td rowspan="2"><img src='data:image/jpeg;base64, {{$book->base64}}' height=200></td>
                                    <td rowspan="2" class="align-middle">
                                        @if($book->status)
                                            <img src="{{ asset('img/check1.png')}}" height=15>
                                        @else
                                            <a  data-toggle="modal" data-target="#myModalConfirm" onclick="confirmbook({{$book->book_id}})"><button type="button" class="btn btn-light"><img src="{{ asset('img/confirm.png')}}" height=30></button></a>
                                            <a  data-toggle="modal" data-target="#myModalDelete" onclick="deletebook({{$book->book_id}})"><button type="button" class="btn btn-light"><img src="{{ asset('img/remove.png')}}" height=30></button></a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">{{Str::words($book->book_title, 50, ' ...->')}}</td>
                                </tr>      
                            @endforeach
                                                
                            </tbody>
                        </table> 
                    @endif
                    
                    
                     
                    
                    <!-- The Modal Confirm-->
                    <div class="modal" id="myModalConfirm">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Warning</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                Are you sure to confirm this book?
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer" id="mfooterconfirm">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>  
                                
                                <form method="POST" action="{{ route('confirmbook') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" name = "bookId" id="bookId">
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                </form>    
                            </div>

                            </div>
                        </div>
                    </div>

                    <!-- The Modal Delete-->
                    <div class="modal" id="myModalDelete">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Warning</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                Are you sure to delete this book?
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

                                <form method="POST" action="{{ route('deletebook') }}">
                                    @csrf
                                    <input type="hidden" class="form-control" name = "bookId" id="bookIddelete">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>  
                            </div>

                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function deletebook(bookid) {
        document.getElementById("bookIddelete").value = bookid;
    };

    function confirmbook(bookid) {
        document.getElementById("bookId").value = bookid;
    };
</script>    
@endsection
