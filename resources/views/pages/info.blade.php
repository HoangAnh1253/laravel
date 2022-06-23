@extends('index')

@section('content')
    <section class="p-4 my-container">
        <h1>My Info</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Birthdate</th>
                    <th scope="col">Phone number</th>
                </tr>
            </thead>
            <tbody>
                <tr id="{{ $user->id }}">
                    <th scope="row">{{ $user->id }}</th>
                    <td class="userName">{{ $user->name }}</td>
                    <td class="userEmail">{{ $user->email }}</td>
                    <td class="userGender">{{ $user->gender ? 'Male' : 'Female' }}</td>
                    <td class="userBirthdate">{{ $user->birthdate->format('m/d/Y') }}</td>
                    <td class="userPhonenumber">{{ $user->phone_number }}</td>
                </tr>
        </table>
    </section>
@endsection
