@extends('backend.layout.app')

@section('bradcrumb')
    <div class="col-md-4">
        <ul class="breadcrumb-title">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}"> <i class="fa fa-home"></i> </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">{{ $name }}</a>
            </li>
            <li class="breadcrumb-item">Edit
            </li>
        </ul>
    </div>
@endsection

@section('app')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('role.update', $group->group_id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="name">Role Name <span class="text-danger">*</span> </label>
                            </div>
                            <div class="col-10">
                                <input type="text"
                                    class="form-control form-control-sm @error('group_name')
                                    is-invalid
                                @enderror"
                                    id="group_name" placeholder="Masukan Role Name"
                                    value="{{ old('group_name', $group->group_name) }}" name="group_name" required>
                                @error('group_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <table class="table-hover text-nowrap table">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th class="text-center">Pages</th>
                                            <th class="text-center">Access</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($page_distincts as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-center">{!! str_replace('_', ' ', $d->page_name) !!}</td>
                                                <td class="text-center">
                                                    @foreach ($pages as $p)
                                                        @if (str_replace('_', ' ', $p->page_name) == str_replace('_', ' ', $d->page_name))
                                                            <div class="d-inline">
                                                                <input type="checkbox" id="{!! $p->page_id !!}"
                                                                    name="{!! $p->page_id !!}" {!! $p->access == 1 ? 'checked' : '' !!}>
                                                                <label for="{!! $p->page_id !!}">
                                                                    {{ $p->action }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <a href="{{ route('role.index') }}" class="btn btn-sm btn-info mx-2"><i
                                        class="fa fa-reply-all"></i></a>
                                <button type="submit" class="btn btn-sm btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
