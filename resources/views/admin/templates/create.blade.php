@extends('layouts.main')

@section('title', __('templates.create'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('templates.create') }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.templates.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="code" class="form-label">{{ __('templates.code') }} *</label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}" 
                                   class="form-control" required>
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nom_fr" class="form-label">{{ __('templates.name_fr') }} *</label>
                            <input type="text" name="nom_fr" id="nom_fr" value="{{ old('nom_fr') }}" 
                                   class="form-control" required>
                            @error('nom_fr')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nom_en" class="form-label">{{ __('templates.name_en') }}</label>
                            <input type="text" name="nom_en" id="nom_en" value="{{ old('nom_en') }}" 
                                   class="form-control">
                            @error('nom_en')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="chemin_blade" class="form-label">{{ __('templates.chemin_blade') }} *</label>
                            <input type="text" name="chemin_blade" id="chemin_blade" value="{{ old('chemin_blade') }}" 
                                   class="form-control" placeholder="{{ __('templates.chemin_blade_placeholder') }}"
                                   required>
                            @error('chemin_blade')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="actif" class="form-label">{{ __('templates.status') }}</label>
                            <select name="actif" id="actif" class="form-control">
                                <option value="1" {{ old('actif', 1) == '1' ? 'selected' : '' }}>{{ __('templates.active') }}</option>
                                <option value="0" {{ old('actif') == '0' ? 'selected' : '' }}>{{ __('templates.inactive') }}</option>
                            </select>
                            @error('actif')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('templates.save') }}</button>
                        <a href="{{ route('admin.templates.index') }}" class="btn btn-secondary">{{ __('templates.back_to_list') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection