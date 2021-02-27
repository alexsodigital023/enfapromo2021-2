<!-- Sidebar -->
<div class="bg-primary container-sidebar">
    <ul class="navbar-nav sidebar sidebar-dark accordion toggled" id="accordionSidebar">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active bg-secondary mb-1">
            <a class="nav-link" href="{{route('home')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item active bg-secondary mb-1">
            <a class="nav-link" href="{{route('tickets')}}">
                <i class="fas fa-fw fa-ticket-alt"></i>
                <span>Tickets</span>
            </a>
        </li>
        <li class="nav-item active bg-secondary mb-1">
            <a class="nav-link" href="{{route('users')}}">
                <i class="fas fa-fw fa-user-circle"></i>
                <span>Usuarios</span>
            </a>
        </li>
        <li class="nav-item active bg-secondary">
            <a class="nav-link" href="{{route('participantes')}}">
                <i class="fas fa-fw fa-users"></i>
                <span>Participantes</span>
            </a>
        </li>

    </ul>
</div>
<!-- End of Sidebar -->