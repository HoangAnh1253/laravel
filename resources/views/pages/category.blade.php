@extends('index')

@section('content')
    <section id="category-section" class="p-4 my-container">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert" style="display: inline-block">
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1>Categories</h1>
        <button onclick="addDataToModal(false, 'add')" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#addCategoryModal"><i class="fa-solid fa-plus"></i>Add</button>
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
                    <tr id="{{ $category->id }}">
                        <th scope="row">{{ $category->id }}</th>
                        <td class="categoryTitle">{{ $category->title }}</td>
                        <td>
                            <button onclick="addDataToModal({{ $category->id }}, 'edit')" type="button"
                                class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editCategoryModal"><i
                                    class="fas fa-pen-to-square"></i>Edit</button>
                            <button onclick="addDataToModal({{ $category->id }}, 'delete')" type="button"
                                class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteCategoryModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $categories->links() !!}
        </div>
        <!-- Add Category Modal -->
        <div class="modal fade modal-add" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategoryForm" method="POST" action="{{ route('addCategory') }}">
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="add-title" class="form-label">Add</label>
                                <input id="add-title" type="text" class="form-control" name="title">
                                <p style="color: red" hidden id='add-title-blank-error'>Please fill in this field</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="add-confirm" onclick="{addCategory()}" type="button" data-bs-dismiss="modal"
                            class="btn btn-success">Confirm</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Category Modal -->
        <div class="modal fade modal-edit" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-title" class="form-label">Title</label>
                            <input id="edit-title" type="text" class="form-control" name="edit-title">
                            <p style="color: red" hidden id='edit-title-blank-error'>Please fill in this field</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="edit-confirm" onclick="{editCategory()}" type="button" data-bs-dismiss="modal"
                            class="btn btn-success">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Category Modal -->
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
                        <form method="POST" id="delete-form" action="/">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
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
        categories = categories.data

        function validateBlank(idInput, idConfirmBtn) {
            confirmBtn = $(`#${idConfirmBtn}`)
            input = $(`#${idInput}`)
            blankError = $(`#${idInput}-blank-error`)

            if (input.val() == '') {
                confirmBtn.prop("disabled", true)
                blankError.prop("hidden", false)
            }
            input.on('input', function() {
                if (this.value == '') {
                    blankError.prop("hidden", false)
                    confirmBtn.prop("disabled", true)
                } else {
                    blankError.prop("hidden", true)
                    confirmBtn.prop("disabled", false)
                }
            })
        }

        function addDataToModal(id, action) {
            if (id) {
                let category = categories.find(category => {
                    return category.id == id
                })

                $(`#${action}-title`).val(category.title)
                confirmBtn = $(`#${action}-confirm`)
                confirmBtn.data("category_id", id);
            }
            if (action == 'edit' || action == 'add') {
                validateBlank(`${action}-title`, `${action}-confirm`)
            }
        }

        function deleteCategory() {
            let deleteForm = $("#delete-form")
            let categoryId = $("#delete-confirm").data('category_id')
            deleteForm.prop("action", `/categories/${categoryId}`)
            deleteForm.submit()
        }

        async function editCategory() {
            categoryId = $("#edit-confirm").data('category_id')
            input = $("#edit-title").val()
            payload = {
                "title": input
            }
            response = await axios.patch(`http://127.0.0.1:8000/api/categories/${categoryId}`, payload)
            error = response.data.error
            if (error) {
                categorySection = $("#category-section")
                if (categorySection.find(".alert-danger").length == 0) {
                            categorySection.prepend(`
                        <div class="alert alert-danger alert-dismissible" role="alert" style="display: inline-block">
                            <div>${error}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);
                    }
            } else {
                editedCategory = response.data.data
                categories.forEach(category => {
                    if (category.id == editedCategory.id) {
                        category.title = editedCategory.title
                        $(`#${editedCategory.id}`).find(".categoryTitle").text(editedCategory.title)
                    }
                });
            }
        }

        function addCategory() {
            addCategoryForm = $(`#addCategoryForm`)
            console.log(addCategoryForm.serializeArray());
            addCategoryForm.submit()
        }

        // This code close alert not found
        const alertTrigger = document.getElementById('liveAlertBtn')
        if (alertTrigger) {
            alertTrigger.addEventListener('click', () => {
                alert('Nice, you triggered this alert message!', 'success')
            })
        }
    </script>
@endsection
