@php use Modules\Notification\Helpers\NotificationHelper; @endphp
    <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->


        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ NotificationHelper::getNotificationCount() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{NotificationHelper::getNotificationCount()}} Notifications</span>
                <div class="dropdown-divider"></div>
                @foreach(NotificationHelper::getNotifications() as $notification)
                    <a href="{{ $notification->getTargetUrl() }}" target="_blank" class="dropdown-item setSeen" data-id="{{$notification->id}}">
                        <i class="fas fa-info-circle mr-2"></i>{{$notification->getTitle()}} - {!! strip_tags(Str::markdown($notification->getContent())) !!}
                        <span class="float-right text-muted text-sm"> {{ \Carbon\Carbon::make($notification->created_at)->diffForHumans() }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach

            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>

    </ul>
</nav>

@pushonce('scripts')
    <script>

    $('.setSeen').click(function () {
        $(this).parent().remove()
        console.log('id', $(this).data('id'))
        $.ajax({
            method: 'POST',
            url: '{{ route('notification.set-seen') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: $(this).data('id')
            },
            success: function (data) {
                console.log(data)
            }
        })
    })

    </script>

@endpushonce

<!-- /.navbar -->
<style>
    a.dropdown-item {
        white-space: normal;
    }
</style>
