<!DOCTYPE html>
<html lang="en">
<head>
    @include('adminlte3.utils.head')
</head>
<body class="dark-mode">
    <div class="wrapper">
        @include('adminlte3.partials.header')
        @include('adminlte3.partials.main-sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('adminlte3.partials.page-header')

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield("content")
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        @include('adminlte3.partials.footer')
        @include('adminlte3.partials.control-sidebar')
    </div>

    @include('adminlte3.utils.scripts')
</body>
</html>
