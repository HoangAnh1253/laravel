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
            </div>
        </form>
        <button onclick="{addDataToModel(false,'addEquipModal')}" class="btn btn-primary mt-4" data-bs-toggle="modal"
            data-bs-target="#addEquipModal">Add</button>
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th scope="col">Serial Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Type</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="equipment-table-body">
                @foreach ($equipments as $equipment)
                    <tr id="{{ $equipment->serial_number }}" class="table-row">
                        <th scope="row">{{ $equipment->serial_number }}</th>
                        <td class="equipName">{{ $equipment->name }}</td>
                        <td class="equipDesc">{{ $equipment->desc }}</td>
                        <td class="equipStatus">{{ $equipment->status }}</td>
                        <td class="equipCategory">{{ $equipment->category->title }}</td>
                        <td>
                            <button onclick="{addDataToModel('<?php echo $equipment->serial_number; ?>','edit')}" value="1"
                                class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editEquipModal"><i
                                    class="fas fa-clock"></i>Edit</button>
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
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input id="edit-name" type="text" class="form-control" name="edit-name" value="abcd">
                        </div>
                        <div class="mb-3">
                            <label for="edit-desc" class="form-label">Description</label>
                            <input id="edit-desc" type="text" class="form-control" name="edit-desc" value="abcd">
                        </div>
                        <div class="mb-3">
                            <label for="edit-status" class="form-label">Status</label>
                            <input class="ms-2" type="radio" name="status" id="edit-status-available"><label
                                for="edit-status-available">Available</label>
                            <input class="ms-2" type="radio" name="status" id="edit-status-used"><label
                                for="edit-status-used">Used</label>
                        </div>
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
                        <div class="mb-3">
                            <label for="add-name" class="form-label">Name</label>
                            <input id="add-name" type="text" class="form-control" name="add-name">
                        </div>
                        <div class="mb-3">
                            <label for="add-desc" class="form-label">Description</label>
                            <input id="add-desc" type="text" class="form-control" name="add-desc">
                        </div>
                        <div class="mb-3">
                            <label for="add-status" class="form-label">Status</label>
                            <input class="ms-2" type="radio" name="status" id="add-status-available"><label
                                for="add-status-available">Available</label>
                            <input class="ms-2" type="radio" name="status" id="add-status-used"><label
                                for="add-status-used">Used</label>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addEquipment()">Add Equipment</button>
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
                            <input class="ms-2" type="radio" name="status" id="delete-status-used" disabled><label
                                for="delete-status-used">Used</label>
                        </div>
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
        let equipments = <?php echo json_encode($equipments); ?>;

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
                }
            })

        }

        async function deleteEquipment() {
            serial_number = $("#delete-confirm").data("serial_number")
            response = await axios.delete(`http://127.0.0.1:8000/api/equipments/${serial_number}`);
            deletedId = response.data.data.serial_number
            $(`#${deletedId}`).remove()
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

        async function addEquipment() {
            addName = $("#add-name").val()
            addDesc = $("#add-desc").val()
            addStatus = $("#add-status-available").prop("checked") ? "available" : "used"
            addCategory = $("#add-category").val()
            payload = {
                "name": addName,
                "desc": addDesc,
                "status": addStatus,
                "categories_id": addCategory
            }
            response = await axios.post('http://127.0.0.1:8000/api/equipments/', payload)
            createdEquipment = response.data.data
            $("#equipment-table-body").append(`<tr id="${createdEquipment.serial_number}"></tr>`)
            newRow = $(`#${createdEquipment.serial_number}`)
            newRow.append(`
                <th scope="row">${createdEquipment.serial_number}</th>
                <td class="equipName">${createdEquipment.name}</td>
                <td class="equipDesc">${createdEquipment.desc}</td>
                <td class="equipStatus">${createdEquipment.status}</td>
                <td class="equipCategory">${createdEquipment.category.title}</td>
                <td>
                    <button onclick="{addDataToModel('${createdEquipment.serial_number}','edit')}" value="1"
                        class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editEquipModal"><i
                            class="fas fa-clock"></i>Edit</button>
                    <button onclick="{addDataToModel('${createdEquipment.serial_number}','delete')}" class="btn btn-danger"
                        data-bs-toggle="modal" data-bs-target="#deleteEquipModal">Delete</button>
                </td>
            `)
        }

        function searchEquipment(e) {
            searchInput = $("#search-input")
            searchForm = $("#search-form")
            //console.log(searchInput.val(), searchForm);
            searchForm.prop('action', `/equipments/${searchInput.val()}`)
            //searchForm.submit()
            table = $("#equipment-table-body")
            table.children().not(`#${searchInput.val()}`).prop("hidden", true)
        }
    </script>
@endsection
