@extends('index')

@section('content')
    <section class="p-4 my-container">
        <h1>My Equipments</h1>
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th scope="col">Serial Number</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                </tr>
            </thead>
            <tbody id="equipment-table-body">
                @foreach ($equipments as $equipment)
                    <tr id="{{ $equipment->serial_number }}" class="table-row {{ $equipment->category->title }}">
                        <th scope="row">{{ $equipment->serial_number }}</th>
                        <td class="equipName">{{ $equipment->name }}</td>
                        <td class="equipDesc">{{ $equipment->desc }}</td>
                        <td class="equipCategory">{{ $equipment->category->title }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </section>
@endsection
