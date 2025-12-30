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
                            <h3 class="card-title">Pages</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('admin.posts') }}" style="margin-left:70%;" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <form id="addUser" action="{{ route('admin.storePosts') }}" autocomplete="off" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="successMessage" style="color: green; margin-top: 15px;"></div>
                        <div class="form-group">
                            <label for="floatingfirst">Select Chapter:</label>
                            <select class="form-control" name="category_id">
                                <option value="">Select</option>
                                
                                @foreach($categories as $category)
                                    <!-- Parent category -->
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                        
                                    <!-- Subcategories -->
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}">— {{ $child->name }}</option>
                        
                                        <!-- Grandchild categories -->
                                        @foreach($child->chapters as $grandchild)
                                            <option value="{{ $grandchild->id }}">—— {{ $grandchild->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="floatingfirst">Page Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Post Name">
                            <span class="error" id="sub-category" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Short description..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Content:</label>
                            <textarea id="editor" name="content" class="form-control"
                                placeholder="Write full content here..." rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="cat_image">Image:</label>
                            <input type="file" class="form-control" name="image" placeholder="Category image">
                        </div>
                        <div class="form-group">
                            <label for="cat_image">Pdf:</label>
                            <input type="file" class="form-control" name="pdf" placeholder="Category pdf">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="pass_protected" 
                                       value="1" 
                                       id="pass_protected">
                                <label class="form-check-label" for="pass_protected">
                                    Password Protected
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="isFeature" 
                                       value="1" 
                                       id="isFeature">
                                <label class="form-check-label" for="isFeature">
                                    Is Featured
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="showOnFront"
                                       value="1" 
                                       id="showOnFront">
                                <label class="form-check-label" for="showOnFront">
                                    Show on Front
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cat_image">Order No:</label>
                            <input type="number" class="form-control" name="order_no" placeholder="Enter Order No">
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-lg">Save</button>
                        </div>
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
            
            
            
            <!--<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>-->
            <!--<script>-->
            <!--    CKEDITOR.replace('editor', {-->
            <!--        height: 300,-->
            <!--        extraPlugins: 'colorbutton,colordialog,justify,font,print,pagebreak,table,uploadimage,image2',-->
            <!--        removePlugins: 'easyimage,cloudservices,exportpdf',-->
            <!--        toolbarCanCollapse: true,-->
                    
            <!--        extraAllowedContent: 'iframe[*]',-->
            <!--        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",-->
            <!--        filebrowserUploadMethod: 'form'-->
            <!--    });-->
            <!--</script>-->
            
            
            
            <!--<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>-->
            <!--<script>-->
            <!--CKEDITOR.plugins.addExternal('base64image', '{{ asset('ckeditor/plugins/base64image/') }}/', 'plugin.js');-->
            
            <!--CKEDITOR.replace('editor', {-->
            <!--    height: 400,-->
            <!--    extraPlugins: 'base64image,colorbutton,colordialog,justify,font,print,pagebreak,table,image2',-->
            <!--    removePlugins: 'easyimage,cloudservices,exportpdf',-->
            <!--    toolbarCanCollapse: true,-->
            <!--    toolbar: [-->
            <!--        { name: 'document', items: ['Source'] },-->
            <!--        { name: 'insert', items: ['base64image', 'Table', 'HorizontalRule'] },-->
            <!--        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },-->
            <!--        { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight'] },-->
            <!--        { name: 'styles', items: ['Font', 'FontSize'] },-->
            <!--        { name: 'colors', items: ['TextColor', 'BGColor'] }-->
            <!--    ]-->
            <!--});-->
            <!--</script>-->
            
            
            
            
            
            <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
            <script>
                // Add external plugin for Base64 image
                CKEDITOR.plugins.addExternal('base64image', '{{ asset('ckeditor/plugins/base64image/') }}/', 'plugin.js');
            
                CKEDITOR.replace('editor', {
                    height: 400,
                    // Include all the standard plugins + base64image
                    extraPlugins: 'base64image,colorbutton,colordialog,justify,font,print,pagebreak,table,image2,link,liststyle,smiley,find,preview,autolink,clipboard,dialog,dialogadvtab,format,div,resize',
                    removePlugins: 'easyimage,cloudservices,exportpdf',
                    toolbarCanCollapse: true,
                    extraAllowedContent: 'iframe[*]; img[!src,alt,width,height];',
            
                    // Use full toolbar set (all options)
                    toolbar: [
                        { name: 'document', items: ['Source', '-', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
                        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                        { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                        '/',
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                        { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                        { name: 'insert', items: ['base64image', 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe'] },
                        '/',
                        { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                        { name: 'colors', items: ['TextColor', 'BGColor'] },
                        { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
                    ]
                });
            </script>





            @endsection
