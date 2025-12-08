@extends('layouts.main')

@section('title', __('champs.edit'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('champs.edit') }}: {{ $champ->code }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.champs.update', $champ) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="code" class="form-label">{{ __('champs.code') }} *</label>
                            <input type="text" name="code" id="code" value="{{ old('code', $champ->code) }}" 
                                   class="form-control" required>
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nom_fr" class="form-label">{{ __('champs.name_fr') }} *</label>
                            <input type="text" name="nom_fr" id="nom_fr" value="{{ old('nom_fr', $champ->nom_fr) }}" 
                                   class="form-control" required>
                            @error('nom_fr')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nom_en" class="form-label">{{ __('champs.name_en') }}</label>
                            <input type="text" name="nom_en" id="nom_en" value="{{ old('nom_en', $champ->nom_en) }}" 
                                   class="form-control">
                            @error('nom_en')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type" class="form-label">{{ __('champs.type') }} *</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">{{ __('champs.select_type') }}</option>
                                <option value="text" {{ old('type', $champ->type) == 'text' ? 'selected' : '' }}>{{ __('champs.text') }}</option>
                                <option value="number" {{ old('type', $champ->type) == 'number' ? 'selected' : '' }}>{{ __('champs.number') }}</option>
                                <option value="date" {{ old('type', $champ->type) == 'date' ? 'selected' : '' }}>{{ __('champs.date') }}</option>
                                <option value="boolean" {{ old('type', $champ->type) == 'boolean' ? 'selected' : '' }}>{{ __('champs.boolean') }}</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">{{ __('champs.description') }}</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="form-control">{{ old('description', $champ->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('champs.update') }}</button>
                        <a href="{{ route('admin.champs.index') }}" class="btn btn-secondary">{{ __('champs.back_to_list') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection