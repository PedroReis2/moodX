@extends('layout.fe_master_admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Título -->
            <div class="dashboard-text text-start mb-4">
                <h1>Hello, Admin.</h1>
                <p>Time to take control of your accounts!</p>
            </div>

            <!-- Header com botão + campo de pesquisa -->
            <div class="row align-items-center mb-3">
                <div class="col-md-6 mb-2 mb-md-0">
                    <button class="btn btn-dark" onclick="openAddUserModal()">➕ Add user</button>
                </div>
                <div class="col-md-6 text-md-end">
                    <input type="text" class="form-control" placeholder="Search" id="searchInput">
                </div>
            </div>

            <!-- Tabela -->
            <div class="table-responsive" style="min-height:300px;padding-bottom:150px;">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th><th>Email</th><th>Role</th><th>Phone</th>
                            <th>Status</th><th>Archived</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <tr>
                            <td>User Name</td><td>emailuser@mail.pt</td><td>Student</td><td>912345678</td>
                            <td><img src="{{ asset('images/iconActive.png') }}" alt="Active" class="status-icon"></td>
                            <td>No</td>
                            <td class="dropdown-cell">
                                <div class="dropdown">
                                    <button class="btn btn-link p-0 no-caret dropdown-trigger"
                                            data-bs-toggle="dropdown" aria-expanded="false">⋮</button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                                        <li><a class="dropdown-item" href="#" onclick="editUser(this)">✏️ Edit</a></li>
                                        <li><a class="dropdown-item" href="#">🔑 Reset Password</a></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteUser(this)">🗑️ Delete User</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="toggleStatus(this)">🔄 Change Status</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal Add/Edit User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addUserForm">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Name *</label>
              <input type="text" class="form-control" id="userName" required placeholder="Enter full name">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email *</label>
              <input type="email" class="form-control" id="userEmail" required placeholder="user@example.com">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Role *</label>
              <select class="form-select" id="userRole" required>
                <option value="">Select role...</option>
                <option value="Admin">Admin</option>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Phone *</label>
              <input type="tel" class="form-control" id="userPhone" placeholder="Enter phone number" required maxlength="9">
              <small class="form-text text-muted">Only numbers allowed, exactly 9 digits.</small>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" id="addUserBtn" onclick="addUser()">Add User</button>
        <button type="button" class="btn btn-dark" id="editUserBtn" onclick="saveUserChanges()" style="display:none;">Save Changes</button>
      </div>
    </div>
  </div>
</div>


@endsection
