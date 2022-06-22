@extends('index')

@section('content')
    <section class="p-4 my-container">
        <h1>Equipment</h1>
        <form method="GET" id="search-form">
            <div class="input-group">
                <div class="form-outline">
                    <input type="search" id="search-input" class="form-control" />
                </div>
                <button onclick="searchEquipment(event)" id="search-btn" style="height: 38px" type="button"
                    class="btn btn-primary">
                    <i class="fas fa-search">Search</i>
                </button>
                <a href="{{ route('equipment') }}" type="button"
                    class="btn btn-info {{ Route::is('equipment') && !isset($filter) ? 'active' : '' }}">All</a>
                @foreach ($categories as $category)
                    <a href="{{ route('filterEquipment', ['category_id' => $category->id]) }}" type="button"
                        class="btn btn-info {{ isset($filter) && $filter == $category->title ? 'active' : '' }}">{{ $category->title }}</a>
                @endforeach
            </div>

        </form>

        <div style="position: relative" class="autocomplete form-outline">
            <label style="margin-top: 40px" for=""><b>Filter by User</b></label>
            <input id="search-by-user-input" class="form-control" />
            <p style="color: red" hidden id='search-user-equipment-blank-error'>Please fill in this field</p>
            <p style="color: red" hidden id='search-user-equipment-notfound-error'>User not found</p>

            <button onclick="searchUserEquipments()" id="search-user-equipment-confirm" style="height: 38px" type="button"
                class="btn btn-primary" disabled> 
                <i id="" class="fas fa-search">Search</i>
            </button>
            <form id="search-user-equipment-form" method="GET" action="" hidden></form>
        </div>
        <div class="mt-4">
            <button onclick="{addDataToModel(false,'addEquipModal')}" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#addEquipModal">Add</button>
        </div>
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">Serial Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Status</th>
                    <th scope="col">Using by</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="equipment-table-body">
                @foreach ($equipments as $equipment)
                    <tr id="{{ $equipment->serial_number }}" class="table-row {{ $equipment->category->title }}">
                        <th scope="row">{{ $equipment->serial_number }}</th>
                        <td class="equipName">{{ $equipment->name }}</td>
                        <td class="equipDesc">{{ $equipment->desc }}</td>
                        <td class="equipCategory">{{ $equipment->category->title }}</td>
                        <td class="equipStatus">{{ $equipment->status }}</td>
                        <td class="equipUser">
                            {{ isset($equipment->user->name) ? $equipment->user->name . ' (ID: ' . $equipment->user->id . ')' : '' }}
                        </td>

                        <td>
                            <button onclick="{addDataToModel('<?php echo $equipment->serial_number; ?>','edit')}" value="1"
                                class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editEquipModal"><i
                                    class="fas fa-clock"></i>Edit</button>
                            <button onclick="openAssignModal('<?php echo $equipment->serial_number; ?>')" class="btn btn-warning"
                                data-bs-toggle="modal" data-bs-target="#assignEquipModal"><i
                                    class="fas fa-clock"></i>Assign</button>

                            <button onclick="unAssignEquipment(this.parentNode.parentNode.id,this)"
                                class="btn btn-secondary unassign-btn"
                                {{ isset($equipment->user->name) ? '' : 'hidden' }}><i
                                    class="fas fa-clock"></i>Unassigned</button>


                            <button onclick="{addDataToModel('<?php echo $equipment->serial_number; ?>','delete')}" class="btn btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteEquipModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $equipments->links() !!}
        </div>

        <!-- Edit Equipment Modal -->
        <div class="modal fade" id="editEquipModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Equipment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="edit-form">
                            <div class="mb-3">
                                <label for="edit-name" class="form-label">Name</label>
                                <input id="edit-name" type="text" class="form-control" name="edit-name" required>
                                <p style="color: red" hidden id='edit-name-blank-error'>Please fill in this field</p>

                            </div>
                            <div class="mb-3">
                                <label for="edit-desc" class="form-label">Description</label>
                                <input id="edit-desc" type="text" class="form-control" name="edit-desc" required>
                                <p style="color: red" hidden id='edit-desc-blank-error'>Please fill in this field</p>

                            </div>
                            <div class="mb-3" hidden>
                                <label for="edit-status" class="form-label">Status</label>
                                <input class="ms-2" type="radio" name="status" id="edit-status-available"><label
                                    for="edit-status-available">Available</label>
                                <input class="ms-2" type="radio" name="status" id="edit-status-used"><label
                                    for="edit-status-used">Used</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button onclick="editEquipment()" id="edit-confirm" type="button" class="btn btn-primary"
                            data-bs-dismiss="modal">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Equipment Modal -->
        <div class="modal fade " id="addEquipModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Equipment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/equipments" id="add-equipment-form">
                            {{ csrf_field() }}
                            <div class="mb-3 form-group">
                                <label for="add-name" class="form-label">Name</label>
                                <input id="add-name" type="text" class="form-control" name="name" minlength="3"
                                    required>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="add-desc" class="form-label">Description</label>
                                <input id="add-desc" type="text" class="form-control" name="desc" required>
                            </div>

                            <div class="mb3">
                                <label for="add-category" class="form-label">Category</label>
                                <select id="add-category" class="form-select form-select-sm"
                                    aria-label=".form-select-sm example">
                                    @foreach ($categories as $category)
                                        <option value={{ $category->id }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addEquipment()">Add Equipment</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assign Equipment Modal -->
        <div class="modal fade" id="assignEquipModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Equipment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 autocomplete">
                            <label for="assign-euqipment-input" class="form-label">User's name or ID</label>
                            <input id="assign-equipment-input" type="text" class="form-control"
                                name="assign-equipment" value="">
                            <p style="color: red" hidden id='assign-blank-error'>Please fill in this field</p>
                            <p style="color: red" hidden id='assign-notfound-error'>User not found</p>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button disabled onclick="assignEquipment()" id="assign-confirm" type="button"
                            class="btn btn-primary" data-bs-dismiss="modal">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Equipment Modal -->
        <div class="modal fade modal-delete" id="deleteEquipModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Equipment</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="delete-form" action="">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="delete-name" class="form-label">Name</label>
                                <input id="delete-name" type="text" class="form-control" name="delete-name"
                                    value="abcd" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="delete-desc" class="form-label">Description</label>
                                <input id="delete-desc" type="text" class="form-control" name="delete-desc"
                                    value="abcd" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="delete-status" class="form-label">Status</label>
                                <input class="ms-2" type="radio" name="status" id="delete-status-available"
                                    disabled><label for="delete-status-available">Available</label>
                                <input class="ms-2" type="radio" name="status" id="delete-status-used"
                                    disabled><label for="delete-status-used">Used</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="delete-confirm" onclick="{deleteEquipment()}" type="button" data-bs-dismiss="modal"
                            class="btn btn-danger">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Button trigger modal -->
    <script>
        var isAssignSelected = false
        let equipments = <?php echo json_encode($equipments); ?>;
        let users = <?php echo json_encode($users); ?>;

        let usersNameId = users.map(function(user) {
            return `${user.name} (ID: ${user.id})`
        })


        $("#search-by-user-input").on('focus', function() {
            autocomplete('search-by-user-input', usersNameId, 'search-user-equipment');
        })


        function searchUserEquipments() {
            userId = $("#search-user-equipment-user-id").val()
            if (!userId || !isAssignSelected) {

                input = $("#search-by-user-input").val()
                index = input.indexOf('(') - 1
                console.log(index);
                id = -1
                userName = ''
                if (index >= 0) {
                    userName = input.substr(0, index)
                    id = input.substr(index + 6, input.length - 1 - index - 6)
                } else {
                    userNameOrId = input
                }
                let assignUser = users.find(user => {
                    return user.id == userNameOrId || user.name == userNameOrId || (user.id == id && user.name ==
                        userName)
                })
                if (assignUser)
                    userId = assignUser.id
            }
            searchForm = $("#search-user-equipment-form")
            searchForm.prop("action", `/equipments/user/${userId}`)
            searchForm.submit()
        }

        function openAssignModal(id) {
            autocomplete('assign-equipment-input', usersNameId, 'assign');
            assignBtn = $("#assign-confirm");
            assignBtn.data("serial_number", id)
        }

        async function unAssignEquipment(serial_number, unAssignBtn) {
            selectdEquipment = equipments.find(equipment => {
                return equipment.serial_number == serial_number
            })


            editName = selectdEquipment.name
            editDesc = selectdEquipment.desc

            payload = {
                "name": editName,
                "desc": editDesc,
                "status": "available",
                "users_id": ""
            }

            response = await axios.patch(`http://127.0.0.1:8000/api/equipments/${serial_number}`, payload)
            editedRow = $(`#${serial_number}`)



            editedRowUser = editedRow.find(".equipUser")
            editedRowUser.text("")

            editedRowStatus = editedRow.find(".equipStatus")
            editedRowStatus.text(response.data.data.status)

            unAssignBtn.hidden = true
        }

        async function assignEquipment() {

            serial_number = $("#assign-confirm").data("serial_number")
            userId = $("#assign-user-id").val()
            selectdEquipment = equipments.find(equipment => {
                return equipment.serial_number == serial_number
            })
            if (!userId || !isAssignSelected) {
                input = $("#assign-equipment-input").val()
                index = input.indexOf('(') - 1
                let userName, id, userNameOrId;
                if (index >= 0) {
                    userName = input.substr(0, index)
                    id = input.substr(index + 6, input.length - 1 - index - 6)
                } else {
                    userNameOrId = input
                }
                let assignUser = users.find(user => {
                    return user.id == userNameOrId || user.name == userNameOrId || (user.id == id && user
                        .name == userName)
                })
                if (assignUser)
                    userId = assignUser.id
            }
            editName = selectdEquipment.name
            editDesc = selectdEquipment.desc
            editStatus = selectdEquipment.status
            payload = {
                "name": editName,
                "desc": editDesc,
                "status": editStatus,
                "users_id": userId
            }

            response = await axios.patch(`http://127.0.0.1:8000/api/equipments/${serial_number}`, payload)
            editedRow = $(`#${serial_number}`)


            editedRowUser = editedRow.find(".equipUser")
            editedRowUser.text(`${response.data.data.user.name} (ID: ${response.data.data.user.id})`)

            editedRowStatus = editedRow.find(".equipStatus")
            editedRowStatus.text(response.data.data.status)

            editedRowUnassignBtn = editedRow.find(".unassign-btn")
            editedRowUnassignBtn.prop("hidden", false)
        }

        function addDataToModel(id, action) {
            $(async function() {
                if (id) {
                    let equipment = {}
                    for (i = 0; i < equipments.length; i++) {
                        if (equipments[i].serial_number === id) {
                            equipment = equipments[i]
                            break
                        }
                    }
                    editNameInput = $(`#${action}-name`)
                    editNameInput.val(equipment.name);

                    editDescInput = $(`#${action}-desc`)
                    editDescInput.val(equipment.desc)

                    availableRadio = $(`#${action}-status-available`)
                    usedRadio = $(`#${action}-status-used`)
                    if (equipment.status == 'available') {
                        availableRadio.prop('checked', true)
                    } else {
                        usedRadio.prop('checked', true)
                    }
                    confirmButton = $(`#${action}-confirm`)
                    confirmButton.data("serial_number", id)

                    if (action == 'edit') {
                        $("#edit-name").on("input", function() {
                            if (this.value == '') {
                                $("#edit-name-blank-error").prop("hidden", false)
                                confirmButton.prop("disabled", true)
                            } else {
                                $("#edit-name-blank-error").prop("hidden", true)
                                if ($("#edit-desc-blank-error").prop("hidden"))
                                    confirmButton.prop("disabled", false)
                            }

                        })
                        $("#edit-desc").on("input", function() {
                            if (this.value == '') {
                                $("#edit-desc-blank-error").prop("hidden", false)
                                confirmButton.prop("disabled", true)
                            } else {
                                $("#edit-desc-blank-error").prop("hidden", true)
                                if ($("#edit-name-blank-error").prop("hidden"))
                                    confirmButton.prop("disabled", false)
                            }
                        })
                    }
                }
            })

        }

        function deleteEquipment() {
            let deleteForm = $("#delete-form")
            let serial_number = $("#delete-confirm").data("serial_number")
            deleteForm.prop("action", `/equipments/${serial_number}`)
            deleteForm.submit()
        }

        function addEquipment() {
            addStatus = "available"
            addCategory = $("#add-category").val()
            $('<input>').attr('type', 'hidden').attr('name', 'status').attr('value', addStatus).appendTo(
                '#add-equipment-form');
            $('<input>').attr('type', 'hidden').attr('name', 'categories_id').attr('value', addCategory).appendTo(
                '#add-equipment-form');
            $("#add-equipment-form").validate();
            $("#add-equipment-form").submit();
        }

        async function editEquipment() {

            serial_number = $("#edit-confirm").data("serial_number")
            editName = $("#edit-name").val()
            editDesc = $("#edit-desc").val()
            editStatus = $("#edit-status-available").prop("checked") ? "available" : "used"
            payload = {
                "name": editName,
                "desc": editDesc,
                "status": editStatus
            }

            if (editName == '') {
                $("#edit-name").after("<p>Please fill in this field</p>")

            } else if (editDesc == '') {

                $("#edit-desc").after("<p>Please fill in this field</p>")
            } else {
                response = await axios.patch(`http://127.0.0.1:8000/api/equipments/${serial_number}`, payload)
                editedRow = $(`#${serial_number}`)

                editedRowName = editedRow.find(".equipName")
                editedRowName.text(response.data.data.name)

                editedRowDesc = editedRow.find(".equipDesc")
                editedRowDesc.text(response.data.data.desc)

                editedRowStatus = editedRow.find(".equipStatus")
                editedRowStatus.text(response.data.data.status)

                for (i = 0; i < equipments.length; i++) {
                    if (equipments[i].serial_number == serial_number) {
                        equipments[i].name = editedRowName.text()
                        equipments[i].desc = editedRowDesc.text()
                        equipments[i].status = editedRowStatus.text()
                    }
                }
            }
        }



        function searchEquipment(e) {
            searchForm = $("#search-form")
            searchInput = $("#search-input")
            serial_number = searchInput.val();

            searchForm.prop("action", `/equipments/${serial_number}`)
            searchForm.submit()
        }

        function filterAll() {
            table = $("#equipment-table-body")
            table.children().prop("hidden", false)
        }

        function filterByCategory(category) {
            table = $("#equipment-table-body")
            table.children().not(`#${category}`).prop("hidden", true)
            table.find(`.${category}`).prop("hidden", false)
        }


        function autocomplete(id, arr, action) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            let currentFocus;
            inp = document.getElementById(id);
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                let a, b, i, val = this.value;
                isAssignSelected = false
                if (val == '') {
                    $(`#${action}-confirm`).prop("disabled", true)
                    $(`#${action}-blank-error`).prop("hidden", false)
                } else {
                    $(`#${action}-blank-error`).prop("hidden", true)
                }
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");

                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");

                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                let found = false
                /*for each item in the array...*/
                for (let i = 0; i < arr.length; i++) {

                    /*check if the item contains the text field value:*/
                    let index = arr[i].toUpperCase().indexOf(val.toUpperCase())
                    if (index >= 0) {

                        found = true
                        $(`#${action}-confirm`).prop("disabled", false)
                        $(`#${action}-notfound-error`).prop("hidden", true)
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = arr[i].substr(0, index)
                        b.innerHTML += "<strong>" + arr[i].substr(index, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(index + val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/

                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/

                            isAssignSelected = true;
                            inp.value = this.getElementsByTagName("input")[0].value;
                            inp.innerHTML += "<input id='" + action + "-user-id' type='hidden' value='" +
                                users[i]
                                .id + "'>";
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);

                    }
                }
                if (!found) {
                    $(`#${action}-confirm`).prop("disabled", true)
                    $(`#${action}-notfound-error`).prop("hidden", false)
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    isAssignSelected = true
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }
    </script>
@endsection
