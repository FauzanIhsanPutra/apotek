@extends('layouts.template')

@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="POST" class="card p-5">
        @csrf
        @method('PATCH')

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
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role:</label>
            <div class="col-sm-10">
                <select class="form-select" name="role" id="role" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>kasir</option>
                    <!-- Add other roles as needed -->
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Ubah Password :</label>
            <div class="col-sm-10 d-flex">
                <input type="password" class="form-control" id="password" name="password" value="{{ $user['password'] }}">
                <button type="button" class="btn btn-secondary ms-2" onclick="showPassword()">Lihat</button>
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Ubah Data</button>
    </form>
    
    <script>
        function showPassword() {
            var passwordField = document.getElementById("password");
            var originalType = passwordField.type;
            
            passwordField.type = "text"; d
    
           
            setTimeout(function() {
                passwordField.type = originalType;
            }, 3000);
        }
        
    </script>
    @endsection
