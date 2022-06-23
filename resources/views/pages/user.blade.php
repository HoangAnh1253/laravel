@extends('index')

@section('content')
    <section id="user-section" class="p-4 my-container">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert" style="display: inline-block">
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1>Users</h1>
        <button onclick="addDataToModal(false, 'add')" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#addUserModal"><i class="fa-solid fa-plus"></i>Add</button>
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
                        <td class="userBirthdate">{{ $user->birthdate->format('m/d/Y') }}</td>
                        <td class="userPhonenumber">{{ $user->phone_number }}</td>
                        <td>
                            <button onclick="addDataToModal({{ $user->id }}, 'edit')" type="button"
                                class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editUserModal"><i
                                    class="fas fa-pen-to-square"></i>Edit</button>
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
                                    <input id="add-male-input" class="form-check-input" type="radio" name="gender"
                                        value="1" id="flexRadioDefault1" checked>
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
                                <input id="add-birthdate-input" type="date" class="form-control" name="birthdate"
                                    max={{ date_create('now')->format('Y-m-d') }} required>
                            </div>
                            <div class="mb-3">
                                <label for="add-phone-input" class="form-label">Phone Number</label>
                                <input id="add-phone-input" type="text" class="form-control" name="phone_number"
                                    required minlength="9" maxlength="11">
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
                        <form action="" id="editUserForm" method="POST">
                            <div class="mb-3">
                                <label for="edit-name-input" class="form-label">Name</label>
                                <input id="edit-name-input" type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-email-input" class="form-label">Email</label>
                                <input id="edit-email-input" type="email" class="form-control" name="email"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-gender-input" class="form-label">Gender</label>
                                <div class="form-check ms-4" style="display: inline-block ">
                                    <input class="form-check-input" type="radio" name="gender" value='1'
                                        id="edit-gender-male" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check ms-4" style="display: inline-block ">
                                    <input class="form-check-input" type="radio" name="gender" value='0'
                                        id="edit-gender-female">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Female
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit-birthdate-input" class="form-label">Birthdate</label>
                                <input id="edit-birthdate-input" type="date" class="form-control" name="birthdate"
                                    max={{ date_create('now')->format('Y-m-d') }} required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-phone-input" class="form-label">Phone Number</label>
                                <input id="edit-phone-input" type="text" class="form-control" name="phone_number"
                                    required minlength="9">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="edit-confirm" onclick="{editUser()}" type="button"
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
                                <label for="delete-name-input" class="form-label">Name</label>
                                <input id="delete-name-input" type="text" class="form-control" name="name"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label for="delete-email-input" class="form-label">Email</label>
                                <input id="delete-email-input" type="email" class="form-control" name="email"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label for="delete-gender-input" class="form-label">Gender</label>
                                <div class="form-check ms-4" style="display: inline-block ">
                                    <input class="form-check-input" type="radio" name="gender" value='1'
                                        id="delete-gender-male" checked disabled>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check ms-4" style="display: inline-block ">
                                    <input class="form-check-input" type="radio" name="gender" value='0'
                                        id="delete-gender-female" disabled>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Female
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="delete-birthdate-input" class="form-label">Birthdate</label>
                                <input id="delete-birthdate-input" type="date" class="form-control" name="birthdate"
                                    max={{ date_create('now')->format('Y-m-d') }} disabled>
                            </div>
                            <div class="mb-3">
                                <label for="delete-phone-input" class="form-label">Phone Number</label>
                                <input id="delete-phone-input" type="text" class="form-control" name="phone_number"
                                    disabled minlength="9" maxlength="11">
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

        function addDataToModal(id, action) {
            let user = users.find(user => {
                return user.id == id
            })

            $(`#${action}-name-input`).val(user.name)
            $(`#${action}-email-input`).val(user.email)
            maleRadio = $(`#${action}-gender-male`)
            femaleRadio = $(`#${action}-gender-female`)
            if (user.gender) {
                maleRadio.prop("checked", true)
                femaleRadio.prop("checked", false)

            } else {
                maleRadio.prop("checked", false)
                femaleRadio.prop("checked", true)

            }

            $(`#${action}-birthdate-input`).val(user.birthdate.substr(0, 10))
            $(`#${action}-phone-input`).val(user.phone_number)

            confirmButton = $(`#${action}-confirm`)
            confirmButton.data("id", id)
        }

        function addUser() {
            form = $("#addUserForm")
            form.validate()
            form.submit()
        }

        async function editUser() {
            userId = $("#edit-confirm").data("id")
            editForm = $("#editUserForm")
            name = $("#edit-name-input").val()
            birthdate = $("#edit-birthdate-input").val()
            email = $("#edit-email-input").val()
            gender = $("#edit-gender-male").prop("checked")
            phone = $("#edit-phone-input").val()

            payload = {
                name: name,
                email: email,
                birthdate: birthdate,
                phone_number: phone,
                gender: gender
            }


            editForm.on('submit', async function(event) {
                event.preventDefault()
                _nameInput = this.querySelector("#edit-name-input").value
                _emailInput = this.querySelector("#edit-email-input").value
                _phoneInput = this.querySelector("#edit-phone-input").value
                
                allNotBlank = _nameInput && _emailInput && _phoneInput
        
                if (allNotBlank) {
                    response = await axios.patch(`http://127.0.0.1:8000/api/users/${userId}`, payload)
                    error = response.data.error ? response.data.error : ''
                    if (error) {
                        userSection = $("#user-section")

                        if (userSection.find(".alert-danger").length == 0) {
                            $("#user-section").prepend(`
                        <div class="alert alert-danger alert-dismissible" role="alert" style="display: inline-block">
                            <div>${error}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);
                        }
                    } else {
                        updatedUser = response.data.data

                        editedRow = $(`#${updatedUser.id}`)
                        updateBirthdate = new Date(updatedUser.birthdate)

                        editedRow.find('.userName').text(updatedUser.name)
                        editedRow.find('.userEmail').text(updatedUser.email)
                        editedRow.find('.userBirthdate').text(updateBirthdate.toLocaleDateString("en-US"))
                        editedRow.find('.userGender').text(updatedUser.gender ? "Male" : "Female")
                        editedRow.find('.userPhonenumber').text(updatedUser.phone_number)

                        for (i = 0; i < users.length; i++) {
                            if (users[i].id = updatedUser.id) {
                                users[i].name = updatedUser.name
                                users[i].email = updatedUser.email
                                users[i].phone_number = updatedUser.phone_number
                                users[i].gender = updatedUser.gender
                                users[i].birthdate = updatedUser.birthdate
                            }
                        }
                    }


                    //editModal = $("#editUserModal")
                    //editModal.find(".btn-secondary").click()

                }
            })

            editForm.validate()
            editForm.submit()

        }

        function deleteUser() {
            deleteForm = $("#delete-form")
            userId = $("#delete-confirm").data("id")
            deleteForm.prop("action", `/users/${userId}`)
            deleteForm.submit()
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
