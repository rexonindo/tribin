@extends('frame')

@section('konten')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User Registration</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>

<div class="row">
    <div class="col mb-1">
        <div class="input-group mb-1">
            <span class="input-group-text" id="basic-addon4">User Name</span>
            <input type="text" class="form-control" placeholder="User Name" aria-label="User Name" aria-describedby="basic-addon4">
        </div>
    </div>
    <div class="col mb-1">
        <div class="input-group mb-1">
            <span class="input-group-text" id="basic-addon1">Email</span>
            <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
        </div>
    </div>
</div>
<div class="row">
    <div class="col mb-1">
        <div class="input-group mb-1">
            <span class="input-group-text" id="basic-addon2">Password</span>
            <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
        </div>
    </div>
    <div class="col mb-1">
        <div class="input-group mb-1">
            <span class="input-group-text" id="basic-addon3">Password Confirmation</span>
            <input type="password" class="form-control" placeholder="Password Confirmation" aria-label="Password" aria-describedby="basic-addon3">
        </div>
    </div>
</div>
<div class="row">
    <div class="col mb-1">
        <div class="input-group mb-1">
            <span class="input-group-text" id="basic-addon2">Roles</span>
            <select class="form-select">
                @foreach($RSRoles as $r)
                <option value="{{ $r->name }}">{{ $r->description }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@endsection