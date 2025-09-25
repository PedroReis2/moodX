@extends('layout.fe_master_admin')

@section('title', 'Admin Dashboard')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

<h2 class="dashboard-title">Hello, Admin.</h2>
<p class="dashboard-subtitle">
    Time to take control of your accounts!
</p>

<!-- Linha topo: botão e search -->
<div class="admin-actions-row">
    <button id="openModalBtn" class="btn btn-black">
        <span style="margin-right: 6px;">➕</span> Add user
    </button>

    <input type="text" id="userSearch" class="admin-search" placeholder="Search users...">
</div>

<!-- Tabela de utilizadores -->
<div class="table-responsive">
    <table class="table" id="usersTable">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th class="status-col">Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr data-user-id="{{ $user->id }}">
                <td>{{ $user->name }}</td>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                        @if($user->role_id == 1)
                            Admin
                        @elseif($user->role_id == 2)
                            Teacher
                        @elseif($user->role_id == 3)
                            Student
                        @else
                            Unknown
                        @endif
                </td>
                <td class="status-col">
                    <span class="status-indicator {{ $user->status ? 'active' : 'inactive' }}">
                        {{ $user->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="dropdown-cell">
                    <div class="dropdown">
                        <button class="dropdown-trigger" type="button">⋮</button>
                        <div class="dropdown-menu-custom">
                            <a class="dropdown-item edit-user-btn"
                               data-user-id="{{ $user->id }}"
                               data-username="{{ $user->name }}"
                               data-firstname="{{ $user->first_name }}"
                               data-lastname="{{ $user->last_name }}"
                               data-email="{{ $user->email }}"
                               data-role="{{ $user->role_id }}"
                               href="#">
                               <span>✏️</span> Edit
                            </a>
                            <a class="dropdown-item" href="{{ route('password.change', $user->id) }}">
                                <span>🔑</span> Reset Password
                            </a>
                            <a class="dropdown-item text-danger delete-user-btn"
                               data-user-id="{{ $user->id }}"
                               data-username="{{ $user->first_name }} {{ $user->last_name }}"
                               href="#">
                               <span>🗑️</span> Delete User
                            </a>
                            <a class="dropdown-item change-status-btn"
                               data-user-id="{{ $user->id }}"
                               data-username="{{ $user->first_name }} {{ $user->last_name }}"
                               data-current-status="{{ $user->status ? 'active' : 'inactive' }}"
                               href="#">
                                <span>🔄</span> Change Status
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- MODAL DE ADIÇÃO DE UTILIZADOR -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <span id="closeModalBtn" class="modal-close">&times;</span>
        <h3>Add New User</h3>

        <form class="modal-form" method="POST" action="{{ route('store_user_by_admin') }}">
            @csrf
            <div class="form-group">
                <label for="add_username">Username *</label>
                <input type="text" id="add_username" class="form-control"
                       placeholder="Enter Username" name="username" required>
            </div>

            <div class="form-group">
                <label for="add_first_name">First Name *</label>
                <input type="text" id="add_first_name" class="form-control"
                       placeholder="Enter first name" name="first_name" required>
            </div>

            <div class="form-group">
                <label for="add_last_name">Last Name *</label>
                <input type="text" id="add_last_name" class="form-control"
                       placeholder="Enter last name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="add_email">Email *</label>
                <input type="email" id="add_email" class="form-control"
                       placeholder="user@example.com" name="email" required>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="add_role">Role *</label>
                <select id="add_role" name="role_id" class="form-control" required>
                    <option value="">Select role...</option>
                    <option value="1">Admin</option>
                    <option value="2">Teacher</option>
                    <option value="3">Student</option>
                </select>
            </div>

            <button type="submit" class="btn btn-black" style="margin-top: 10px;">
                Add User
            </button>
        </form>
    </div>
</div>

<!-- MODAL DE EDICAO DE UTILIZADOR -->
<div id="updateUserModal" class="modal">
    <div class="modal-content">
        <span id="closeModalBtnUpdate" class="modal-close">&times;</span>
        <h3>Update User</h3>

        <form class="modal-form" method="POST" action="{{ route('update_user_by_admin') }}">
            @csrf
            @method('PUT')
            <input type="hidden" id="update_user_id" name="user_id">

            <div class="form-group">
                <label for="update_username">Username *</label>
                <input type="text" id="update_username" class="form-control"
                       placeholder="Enter Username" name="username" required>
            </div>

            <div class="form-group">
                <label for="update_first_name">First Name *</label>
                <input type="text" id="update_first_name" class="form-control"
                       placeholder="Enter first name" name="first_name" required>
            </div>

            <div class="form-group">
                <label for="update_last_name">Last Name *</label>
                <input type="text" id="update_last_name" class="form-control"
                       placeholder="Enter last name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="update_email">Email *</label>
                <input type="email" id="update_email" class="form-control"
                       placeholder="user@example.com" name="email" required>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="update_role">Role *</label>
                <select id="update_role" name="role_id" class="form-control" required>
                    <option value="">Select role...</option>
                    <option value="1">Admin</option>
                    <option value="2">Teacher</option>
                    <option value="3">Student</option>
                </select>
            </div>

            <button type="submit" class="btn btn-black" style="margin-top: 10px;">
                Update User
            </button>
        </form>
    </div>
</div>

<!-- MODAL DE CONFIRMAÇÃO DE STATUS -->
<div id="statusModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" id="closeStatusModal">&times;</span>
        <h3>Change User Status</h3>
        <p id="statusModalMessage"></p>
        <div class="modal-actions">
            <button type="button" id="cancelStatusChange" class="btn btn-secondary">Cancel</button>
            <button type="button" id="confirmStatusChange" class="btn btn-primary">Confirm</button>
        </div>
    </div>
</div>

<!-- MODAL DE CONFIRMAÇÃO DE Eliminacao de user -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" id="closeDeleteModal">&times;</span>
        <h3>Delete User</h3>
        <p id="deleteModalMessage"></p>
        <div class="modal-actions">
            <button type="button" id="cancelDelete" class="btn btn-secondary">Cancel</button>
            <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
        </div>
    </div>
</div>

@endsection
