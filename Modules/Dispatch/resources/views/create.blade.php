@extends("adminlte3.layouts.app")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Adminlte3")
@section("content")
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Dispatch</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('dispatch.store') }}" class="dispatchStoreForm" method="post">
                @csrf
                @include('dispatch::partials.form')
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>

        </div>
    </div>

@endsection


