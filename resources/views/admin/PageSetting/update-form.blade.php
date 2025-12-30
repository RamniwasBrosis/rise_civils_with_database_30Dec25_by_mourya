@extends('admin.layout.main')



@section('content')

<br>
<div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title">Page Setting</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.posts') }}" style="margin-left:70%;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <form action="{{ route('admin.page.setting.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    
                        <div class="form-group mb-3">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone"  class="form-control" placeholder="Enter phone number" value="{{ $pageData?->phone }}" >
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="whatsapp">WhatsApp Number:</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" placeholder="Enter WhatsApp number" value="{{ $pageData?->whatapp_number }}" >
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" value="{{ $pageData?->email }}" >
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="address">Address:</label>
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter full address">{{ $pageData?->address }}</textarea>
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="logo">Logo Image:</label>
                            <input type="file" name="logo" id="logo" class="form-control">
                            <div class="mt-2"><img src="{{ url($pageData?->logo_image) }}" width="50px" height="50px" /></div>
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="about">About Us Content:</label>
                            <textarea name="about" id="about" class="form-control" rows="5" placeholder="Write about your company...">{{ $pageData?->aboutus_content }}</textarea>
                        </div>
                    
                        <hr>
                        <h5>Social Media Links</h5>
                    
                        <div class="form-group mb-3">
                            <label for="facebook">Facebook:</label>
                            <input type="url" name="facebook" id="facebook" class="form-control" placeholder="https://facebook.com/yourpage" value="{{ $pageData?->facebook_url }}">
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="twitter">Twitter (X):</label>
                            <input type="url" name="twitter" id="twitter" class="form-control" placeholder="https://twitter.com/yourprofile" value="{{ $pageData?->twitter_url }}">
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="youtube">YouTube:</label>
                            <input type="url" name="youtube" id="youtube" class="form-control" placeholder="https://youtube.com/yourchannel" value="{{ $pageData?->youtube_url }}">
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="instagram">Instagram:</label>
                            <input type="url" name="instagram" id="instagram" class="form-control" placeholder="https://instagram.com/yourpage" value="{{ $pageData?->instagram_url }}">
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="pinterest">Pinterest:</label>
                            <input type="url" name="pinterest" id="pinterest" class="form-control" placeholder="https://pinterest.com/yourprofile" value="{{ $pageData?->pinsert_url }}">
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </form>

                </div>
            </div>

            @endsection



            @section('inlinescript')

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
            <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#myTable').DataTable(); // No ajax needed
                });
            </script>
            <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
            <script>
                // ClassicEditor.create(document.querySelector('#editor'))
                //     .catch(error => console.error(error));
                
                
                ClassicEditor.create(document.querySelector('#editor'), {
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'insertTable', 'uploadImage', 'blockQuote', 'undo', 'redo'
                    ],
                    ckfinder: {
                        uploadUrl: '/store-posts' // your upload route
                    },
                    image: {
                        toolbar: [
                            'imageTextAlternative', 'imageStyle:full', 'imageStyle:side', 'linkImage'
                        ]
                    }
                })
                .then(editor => {
                 
                    const editable = editor.ui.view.editable.element;
                    editable.style.minHeight = '300px';
                    editable.style.maxHeight = '600px';
                    editable.style.overflowY = 'auto';
                })
                .catch(error => console.error(error));
            </script>


            @endsection
