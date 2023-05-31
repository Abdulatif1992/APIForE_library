@extends('dashboard')

@section('content')
<div class="container">    
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Create new book') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('savebook') }}" name="theForm" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group" style="width:200px">
                            <label for="bookId">Book id</label>
                            <input type="text" class="form-control" name = "bookId" id="bookId" readonly>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="bookName">Book name</label>
                            <input type="text" class="form-control" name = "bookName" id="bookName" onchange="getbookId()" placeholder="Book name">
                        </div>
                        <div class="form-group">
                            <label for="bookTitle">Book title</label>
                            <textarea class="form-control" name="bookTitle" id="bookTitle" rows="3"></textarea>
                        </div> 
                        <br> 
                        <div class="form-group">
                            <label for="img">Choose image</label><br>
                            <input type="file" class="form-control-file" name="img" id="img" accept="image/*">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="epub">Choose epub book</label><br>
                            <input type="file" class="form-control-file" name="epub" id="epub" accept=".epub">
                        </div> 
                        <p>
                        <p></p>
                        <div class="form-group">   
                            <button style="float: right;" type="button" class="btn btn-success" onclick="submitForm()">Submit</button > 
                        </div>   
                    </form>                  


                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function submitForm()
    {
        var bookName = document.getElementById("bookName").value;
        var title = document.getElementById("bookTitle").value;
        let img = document.getElementById("img");
        let epub = document.getElementById("epub");

        if(bookName!="" & title!="" & img.files.length!=0 & epub.files.length!=0)
        {
            document.theForm.submit();
        }
        
    }

    function getbookId()
    {
        $.ajax({
            url: '/getbookid', // Replace '1' with the desired user ID
            method: 'GET',
            success: function(response) {
                // Handle the response from the server
                console.log(response);
                document.getElementById("bookId").value = response;

            },
            error: function(xhr) {
                // Handle any errors
                console.log(xhr.responseText);
            }
        });
    }
</script>    

@endsection
