@extends('layouts.main')

@section('title', __('champs.title'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('champs.list') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.champs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('champs.add_new') }}
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ __('champs.name') }}</th>
                                <th>{{ __('champs.type') }}</th>
                                <th>{{ __('champs.required') }}</th>
                                <th>{{ __('champs.template') }}</th>
                                <th>{{ __('champs.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($champs as $champ)
                            <tr>
                                <td>{{ $champ->id }}</td>
                                <td>{{ $champ->name }}</td>
                                <td>{{ $champ->type }}</td>
                                <td>
                                    @if($champ->required)
                                        <span class="badge bg-success">{{ __('champs.yes') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('champs.no') }}</span>
                                    @endif
                                </td>
                                <td>{{ $champ->facture_template->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.champs.edit', $champ->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> {{ __('champs.edit') }}
                                    </a>
                                    <form action="{{ route('admin.champs.destroy', $champ->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ __('champs.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> {{ __('champs.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('champs.no_records_found') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $champs->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection