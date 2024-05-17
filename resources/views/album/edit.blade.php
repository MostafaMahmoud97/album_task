@extends('layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Albums</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Edit Album</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <form method="post" enctype="multipart/form-data">
                        <input id="album_id" type="text" value="{{$Album->id}}" hidden>
                        @csrf
                    <div class="col-lg-12 col-md-12">
                        <div class="card custom-card" id="contentthumb">
                            <div class="card-body ht-100p">
                                <div class="form-group" style="margin-top: 20px">
                                    <label>Album Name</label>
                                    <input id="AlbumName" type="text" class="form-control" value="{{$Album->name}}" placeholder="Enter album name" name="name" required>
                                </div>
                                <br>
                                <div class="text-wrap">
                                    <div class="example">
                                        <div class="row">
                                            @foreach($Album->Pictures as $picture)
                                                <input class="pic_id" value="{{$picture->id}}" type="text" hidden>
                                                <div class="col-xl-4 col-lg-4">
                                                    <div class="img-thumbnail mb-3">
                                                        <a>
                                                            <img src="{{$picture->media->file_path}}" alt="thumb1" class="thumbimg wd-100p" style="height: 280px">
                                                        </a>
                                                        <div class="caption">
                                                            <div class="form-group" style="margin-top: 10px">
                                                                <label>Picture Name</label>
                                                                <input type="text" class="form-control pic-name" value="{{$picture->name}}" placeholder="Enter picture name" required>
                                                            </div>
                                                            <div class="form-group" style="margin-top: 10px">
                                                                <label>Picture Media</label>
                                                                <input type="file" class="form-control pic-media" value="" placeholder="Select Image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                        <button type="submit" id="SubmitForm" class="btn btn-primary mt-3 mb-0">Submit</button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

    <script>
        $(document).ready(function (){
            $("#SubmitForm").click(function (e){
                e.preventDefault();
                var AlbumName = $("#AlbumName").val();
                var AlbumId = $("#album_id").val();
                var PicIds = $('.pic_id');
                var PicNames = $('.pic-name');
                var PicMedia = $('.pic-media');

                if (AlbumName == ""){
                    alert("you must enter album name");
                }

                var formData = new FormData();

                formData.append("name" , AlbumName);

                for (var i = 0;i<PicNames.length;i++){
                    formData.append(`pictures[${i}][id]`,PicIds[i].value);
                    formData.append(`pictures[${i}][name]`,PicNames[i].value);
                    if(PicMedia[i].files.length > 0){
                        formData.append(`pictures[${i}][media]`,PicMedia[i].files[0]);
                    }

                }

                const url = `{{ route('album.update', ':id') }}`.replace(':id', AlbumId);

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        window.location.href = "{{route("album.index")}}";
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status == 422) {
                            // Parse the JSON response to get the errors
                            var errors = xhr.responseJSON.errors;

                            //Display the errors in the error content
                            var errorMessage = "";
                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errorMessage += key + ": " + errors[key] + "\n";
                                }
                            }
                            alert(errorMessage);
                        } else {
                            // Handle other AJAX errors
                            console.log(xhr.responseJSON);
                        }
                    }
                });

            });
        });
    </script>

@endsection
