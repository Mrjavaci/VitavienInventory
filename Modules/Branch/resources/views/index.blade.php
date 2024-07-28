@extends("adminlte3.layouts.app")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Adminlte3")
@section("content")

    @dump(get_defined_vars())

@endsection

@pushOnce('scripts')
    <script></script>
@endpushonce
