@extends('layout.fe_master_admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h2 class="dashboard-title">Hello, Admin.</h2>
    <p class="dashboard-subtitle">
        Time to take control of your accounts!
    </p>

    <!-- Linha topo: botão e search -->
    <div class="admin-actions-row">
        <button id="openModalBtn" class="btn btn-black">
            <span style="margin-right: 6px;">➕</span> Add user
        </button>

        <input type="text" class="admin-search" placeholder="Search">
    </div>

    <!-- Tabela de utilizadores -->
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th class="status-col">Status</th>
                    <th>Archived</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>User Name</td>
                    <td>emailuser@mail.pt</td>
                    <td>Student</td>
                    <td>912345678</td>
                    <td class="status-col">
                        <input type="checkbox" class="status-checkbox" checked>
                    </td>
                    <td>No</td>
                    <td class="dropdown-cell">
                        <div class="dropdown">
                            <button class="dropdown-trigger">⋮</button>
                            <div class="dropdown-menu-custom">
                                <a class="dropdown-item" href="#"><span>✏️</span> Edit</a>
                                <a class="dropdown-item" href="#"><span>🔑</span> Reset Password</a>
                                <a class="dropdown-item text-danger" href="#"><span>🗑️</span> Delete User</a>
                                <a class="dropdown-item change-status" href="#" onclick="openStatusModal('User Name', this)">
                                    <span>🔄</span> Change Status
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Inactive User</td>
                    <td>inactive@mail.pt</td>
                    <td>Teacher</td>
                    <td>987654321</td>
                    <td class="status-col">
                        <input type="checkbox" class="status-checkbox">
                    </td>
                    <td>No</td>
                    <td class="dropdown-cell">
                        <div class="dropdown">
                            <button class="dropdown-trigger">⋮</button>
                            <div class="dropdown-menu-custom">
                                <a class="dropdown-item" href="#"><span>✏️</span> Edit</a>
                                <a class="dropdown-item" href="#"><span>🔑</span> Reset Password</a>
                                <a class="dropdown-item text-danger" href="#"><span>🗑️</span> Delete User</a>
                                <a class="dropdown-item change-status" href="#" onclick="openStatusModal('Inactive User', this)">
                                    <span>🔄</span> Change Status
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- MODAL DE ADIÇÃO DE UTILIZADOR -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span id="closeModalBtn" class="modal-close">&times;</span>
            <h3>Add New User</h3>

            <div class="modal-form">
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" class="form-control" placeholder="Enter full name">
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" class="form-control" placeholder="user@example.com">
                </div>

                <div class="form-group">
                    <label>Role *</label>
                    <select class="form-control">
                        <option value="">Select role...</option>
                        <option value="admin">Admin</option>
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Phone *</label>
                    <input type="text" class="form-control" placeholder="Enter phone number">
                    <small>Only numbers allowed, exactly 9 digits.</small>
                </div>

                <button class="btn btn-black" style="margin-top: 10px;">Add User</button>
            </div>
        </div>
    </div>

    <!-- MODAL DE CONFIRMAÇÃO DE STATUS -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" id="closeStatusModal">&times;</span>
            <h3>Change User Status</h3>
            <p id="statusModalMessage"></p>
            <div class="modal-actions">
                <button id="cancelStatusChange">Cancel</button>
                <button id="confirmStatusChange">Confirm</button>
            </div>
        </div>
    </div>
@endsection
