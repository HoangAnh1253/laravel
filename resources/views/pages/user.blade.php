@extends('index')

@section('content')
    <section class="p-4 my-container">
        <h1>Users</h1>
        <button onclick="addDataToModal(false, 'add')" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#addUserModal">Add</button>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Birthdate</th>
                    <th scope="col">Phone number</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr id="{{ $user->id }}">
                        <th scope="row">{{ $user->id }}</th>
                        <td class="userName">{{ $user->name }}</td>
                        <td class="userEmail">{{ $user->email }}</td>
                        <td class="userGender">{{ $user->gender ? 'Male' : 'Female' }}</td>
                        <td class="userBirthdate">{{ $user->birthdate->format('d/m/Y') }}</td>
                        <td class="userPhonenumber">{{ $user->phone_number }}</td>
                        <td>
                            <button onclick="addDataToModal({{ $user->id }}, 'edit')" type="button"
                                class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                            <button onclick="addDataToModal({{ $user->id }}, 'delete')" type="button"
                                class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $users->links() !!}
        </div>
        <!-- Add User Modal -->
        <div class="modal fade modal-add" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm" method="POST" action="{{ route('addUser') }}">
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="add-name-input" class="form-label">Name</label>
                                <input id="add-name-input" type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="add-email-input" class="form-label">Email</label>
                                <input id="add-email-input" type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="add-gender-input" class="form-label">Gender</label>
                                <div class="form-check ms-4" style="display: inline-block ">
                                    <input id="add-male-input" class="form-check-input" type="radio" name="gender" value="1"
                                        id="flexRadioDefault1" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check ms-4" style="display: inline-block ">
                                    <input class="form-check-input" type="radio" name="gender" value="0"
                                    id="add-female-input">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Female
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="add-birthdate-input" class="form-label">Birthdate</label>
                                <input id="add-birthdate-input" type="date" class="form-control" name="birthdate" max={{date_create('now')->format('Y-m-d')}}
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="add-phone-input" class="form-label">Phone Number</label>
                                <input id="add-phone-input" type="text" class="form-control" name="phone_number"  required minlength="9" maxlength="11">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="add-confirm" onclick="{addUser()}" type="button"
                            class="btn btn-success">Confirm</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit User Modal -->
        <div class="modal fade modal-edit" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name-input" class="form-label">Name</label>
                            <input id="edit-name-input" type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-email-input" class="form-label">Email</label>
                            <input id="edit-email-input" type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-gender-input" class="form-label">Gender</label>
                            <div class="form-check ms-4" style="display: inline-block ">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Male
                                </label>
                            </div>
                            <div class="form-check ms-4" style="display: inline-block ">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Female
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-birthdate-input" class="form-label">Birthdate</label>
                            <input id="edit-birthdate-input" type="date" class="form-control" name="birthdate" max={{date_create('now')->format('Y-m-d')}}
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-phone-input" class="form-label">Phone Number</label>
                            <input id="edit-phone-input" type="text" class="form-control" name="phone_number"  required minlength="9" maxlength="11">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="edit-confirm" onclick="{editUser()}" type="button" data-bs-dismiss="modal"
                            class="btn btn-success">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete User Modal -->
        <div class="modal fade modal-delete" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
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
                        <button id="delete-confirm" onclick="{deleteUser()}" type="button" data-bs-dismiss="modal"
                            class="btn btn-danger">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script>
        users = <?php echo json_encode($users); ?>;
        users = users.data

        function validateBlank(idInput, idConfirmBtn) {
            // confirmBtn = $(`#${idConfirmBtn}`)
            // input = $(`#${idInput}`)
            // blankError = $(`#${idInput}-blank-error`)

            // if (input.val() == ''){
            //     confirmBtn.prop("disabled", true)
            //     blankError.prop("hidden", false)
            // }
            // input.on('input', function() {
            //     if (this.value == '') {
            //         blankError.prop("hidden", false)
            //         confirmBtn.prop("disabled", true)
            //     } else {
            //         blankError.prop("hidden", true)
            //         confirmBtn.prop("disabled", false)
            //     }
            // })
        }

        function addDataToModal(id, action) {
            // if (id) {
            //     let user = users.find(user => {
            //         return user.id == id
            //     })

            //     $(`#${action}-name`).val(user.title)
            //     confirmBtn = $(`#${action}-confirm`)
            //     confirmBtn.data("user_id", id);
            // }
            // if (action == 'edit' || action == 'add') {
            //     validateBlank(`${action}-name`, `${action}-confirm`)
            // }
        }

        function deleteCategory() {
            // let deleteForm = $("#delete-form")
            // let categoryId = $("#delete-confirm").data('category_id')
            // deleteForm.prop("action", `/categories/${categoryId}`)
            // deleteForm.submit()
        }

        async function editCategory() {
            // categoryId = $("#edit-confirm").data('category_id')
            // input = $("#edit-title").val()
            // payload = {
            //     "title": input
            // }
            // response = await axios.patch(`http://127.0.0.1:8000/api/categories/${categoryId}`, payload)
            // editedCategory = response.data.data
            // categories.forEach(category => {
            //     if (category.id == editedCategory.id) {
            //         category.title = editedCategory.title
            //         $(`#${editedCategory.id}`).find(".categoryTitle").text(editedCategory.title)
            //     }
            // });
        }

        function addCategory() {
            // addCategoryForm = $(`#addCategoryForm`)
            // console.log(addCategoryForm.serializeArray());
            // addCategoryForm.submit()
        }

        function addUser() {
            form = $("#addUserForm")
            form.validate()
            form.submit()
        }
    </script>
@endsection
