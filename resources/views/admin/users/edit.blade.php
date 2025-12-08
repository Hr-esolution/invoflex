@extends('layouts.main')

@section('title', __('users.edit'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('users.edit') }}: {{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name" class="form-label">{{ __('users.name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                   class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('users.email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                   class="form-control" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">{{ __('users.phone') }}</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="form-control">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">{{ __('users.role') }}</label>
                            <select name="role" id="role" class="form-control">
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>{{ __('users.user') }}</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>{{ __('users.admin') }}</option>
                            </select>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('users.password') }}</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control">
                            <small class="form-text text-muted">{{ __('users.leave_blank_if_no_change') }}</small>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">{{ __('users.password_confirmation') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('users.update') }}</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">{{ __('users.back_to_list') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection