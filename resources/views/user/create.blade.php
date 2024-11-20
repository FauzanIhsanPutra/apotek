@extends('layouts.template')

@section('content')
    <style>
        .placeholder-option{
            opacity: 0.5;
        }
    </style>

    <form action="{{ route('user.store') }}" method="POST" class="card p-5">
        @csrf
        @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif
        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Pengguna:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
        </div>
        {{-- <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
            </div>
        </div> --}}
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role:</label>
            <div class="col-sm-10">
                <select class="form-select" name="role" id="role" required>
                    <option class="placeholder-option" selected disabled hidden>Pilih Role Anda</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="user" {{ old('role') == 'kasir' ? 'selected' : '' }}>kasir</option>
                    <!-- Add other roles as needed -->
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tambah Pengguna</button>
    </form>
@endsection
