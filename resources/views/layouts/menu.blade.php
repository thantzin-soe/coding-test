<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

@role('Admin')
<li class="nav-item">
    <a href="#" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            User Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Users</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add User</p>
            </a>
        </li>
    </ul>
</li>
@endrole

<li class="nav-item">
    <a href="#" class="nav-link {{ Request::is('tasks*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Task Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="{{ route('tasks.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Tasks</p>
            </a>
        </li>
        @hasanyrole('Admin|Manager')
        <li class="nav-item">
            <a href="{{ route('tasks.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Task</p>
            </a>
        </li>
        @endhasanyrole
    </ul>
</li>


