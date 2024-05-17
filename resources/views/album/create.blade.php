@extends('layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Albums</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Add New Album</span>
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
                    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                        <div class="card  box-shadow-0 ">
                            <div class="card-body pt-0">
                                <form enctype="multipart/form-data">
                                    <div class="form-group" style="margin-top: 20px">
                                        <label for="exampleInputEmail1">Album Name</label>
                                        <input type="text" class="form-control" id="AlbumName" placeholder="Enter album name">
                                    </div>
                                    <button type="button" id="AddNewImage" class="btn btn-primary mt-3 mb-0">Add Image</button>
                                    <hr>
                                    <div id="images_section">
                                    </div>


                                    <button type="submit" id="SubmitForm" class="btn btn-primary mt-3 mb-0">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
            $("#AddNewImage").click(function (e){
                e.preventDefault();
                var ImagesSection = document.getElementById("images_section");
                var AllImageSection = document.getElementsByClassName("pic");
                var ImagesCount = AllImageSection.length+1;


                var NewTag = `<div class="row pic" id='pic-${ImagesCount}'>`
                +`<div class="form-group col-5">`+
                    `<label>Picture Name</label>`+
                    `<input type="text" class="form-control name-picture"  placeholder="Enter picture name"></div>`+
                    `<div class="form-group col-5">`+
                    `<label>Media</label>`+
                    `<input type="file" class="form-control media-picture"></div>`+
                    `<button type="button" onclick="deleteRowImage('pic-${ImagesCount}')" class="btn btn-danger mt-3 mb-0 delete-image">delete</button></div>`

                ImagesSection.innerHTML += NewTag;

            });
        });
    </script>

    <script>
        function deleteRowImage(row_id){
            const RowImage = document.getElementById(row_id);
            RowImage.remove();
        }
    </script>

    <script>
        $(document).ready(function (){
            $("#SubmitForm").click(function (e){
                e.preventDefault();

                var AlbumName = $("#AlbumName").val();
                var PicNames = $('.name-picture');
                var PicMedia = $('.media-picture');

                if (AlbumName == ""){
                    alert("you must enter album name");
                }

                var formData = new FormData();

                formData.append("name" , AlbumName);

                for (var i = 0;i<PicNames.length;i++){
                    formData.append(`pictures[${i}][name]`,PicNames[i].value);
                    if(PicMedia[i].files.length > 0){
                        formData.append(`pictures[${i}][media]`,PicMedia[i].files[0]);
                    }else{
                        formData.append(`pictures[${i}][media]`,null);
                    }

                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route("album.store") }}',
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
