<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link">
        <span class="brand-text font-weight-light">Vitavien Inventory</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @foreach(\Modules\System\Helpers\Sidebar\PermittedItems::get() as $item)
                    <li class="nav-item">
                        <a href="{{\Illuminate\Support\Facades\Route::has(strtolower($item).'.index') ? route(strtolower($item).'.index') : '#' }}" class="nav-link">
                            <i class="nav-icon far {{\Modules\System\Helpers\Sidebar\ItemToIcon::getIcon($item)}}"></i>
                            <p>
                                {{$item}}
                                <span class="badge badge-info right"></span>
                            </p>
                        </a>
                    </li>

                @endforeach

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
