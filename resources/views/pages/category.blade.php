@extends('index')

@section('content')
    <section class="p-4 my-container">
        <h1>Categories</h1>
        <button type="button" class="btn btn-primary">Add</button>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr id="{{$category->id}}">
                        <th scope="row">{{ $category->id }}</th>
                        <td>{{ $category->title }}</td>
                        <td>
                            <button type="button" class="btn btn-success">Edit</button>
                            <button type="button" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade modal-delete" id="deleteCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="delete-form" action="">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="delete-title" class="form-label">Title</label>
                                <input id="delete-title" type="text" class="form-control" name="delete-title"
                                   disabled>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="delete-confirm" onclick="{deleteCategory()}" type="button" data-bs-dismiss="modal"
                            class="btn btn-danger">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>

        categories = <?php echo json_encode($categories); ?>;

        function addDataToModal(id, action) { 
            if(id){
                
            }
        }

        function deleteCategory(){

        }
    </script>
@endsection


