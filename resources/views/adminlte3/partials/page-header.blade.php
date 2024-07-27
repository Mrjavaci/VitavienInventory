<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $pageTitle ?? 'Panel' }}</h1>
            </div>
            @if(isset($breadcrumbs))
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @foreach($breadcrumbs as $breadcrumb)
                            @if(isset($breadcrumb['url']) && !$loop->last)
                                <li class="breadcrumb-item"><a
                                        href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                            @else
                                <li class="breadcrumb-item active">{{ $breadcrumb['label'] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            @endif
        </div>
    </div><!-- /.container-fluid -->
</section>
