<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="register-user-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text" id="basic-addon4">User Name</span>
                <input type="text" id="userName" onkeyup="userName_eKeyUp(event)" class="form-control" placeholder="User Name" aria-label="User Name" aria-describedby="basic-addon4">
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text" id="basic-addon1">Email</span>
                <input type="email" id="userEmail" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text" id="basic-addon2">Roles</span>
                <select class="form-select" id="role">
                    @foreach($RSRoles as $r)
                    <option value="{{ $r->name }}">{{ $r->description }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Branch</span>
                <select class="form-select" id="branch">
                    @foreach($Branches as $r)
                    <option value="{{ $r->MBRANCH_CD }}">{{ $r->MBRANCH_NM }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text" id="basic-addon1">Phone</span>
                <input type="text" id="userPhone" class="form-control" maxlength="25">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-1 text-center">
            <div class="input-group input-group-sm mb-2">
                <label class="input-group-text">Status</label>
                <div class="input-group-text">
                    <input class="form-check-input" type="checkbox" id="user_cmb_active">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mb-1 text-center">
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary" onclick="btnSaveOnclick(this)">Save</button>
                <button type="button" class="btn btn-outline-primary" onclick="btnResetPasswordOnclick(this)">Reset Password</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-1">
            <table id="tblUserInfo" class="table table-sm table-striped table-bordered" style="width:100%;height:100%;cursor:pointer">
                <thead>
                    <tr>
                        <th>Userid</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Registered Date</th>
                        <th>Ugid</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Nick Name</th>
                        <th>BranchID</th>
                        <th>Branch</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" id="userId">
    <input type="hidden" id="userNickName">
</form>
<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Reset Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1" id="div-alert2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 mb-1">
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="fas fa-lock text-warning"></i></span>
                                <input type="password" class="form-control" id="newPassword" placeholder="Enter new Password here" onkeyup="newPasswordOnKeyPress(event)" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3 mb-1" id="newPasswordInfoContainer">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-1">
                                <span class="input-group-text"><i class="fas fa-lock text-warning"></i></span>
                                <input type="password" class="form-control" id="confirmNewPassword" placeholder="Confirm new Password here" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button class="btn btn-primary" onclick="btnConfirmResetPasswordOnClick(this)">OK</button>
            </div>
        </div>
    </div>
</div>
<script>
    var tableusr = $('#tblUserInfo').DataTable();
    initdataUSRList()

    function initdataUSRList() {
        tableusr = $('#tblUserInfo').DataTable({
            select: true,
            destroy: true,
            scrollX: true,
            ajax: '/user/management',
            columns: [{
                    "data": 'id'
                },
                {
                    "data": 'name'
                },
                {
                    "data": 'email'
                },
                {
                    "data": 'created_at'
                },
                {
                    "data": 'role_name'
                },
                {
                    "data": 'description'
                },
                {
                    "data": 'active'
                },
                {
                    "data": 'nick_name'
                },
                {
                    "data": 'branch'
                },
                {
                    "data": 'MBRANCH_NM'
                },
                {
                    "data": 'phone'
                },
            ],
            columnDefs: [{
                    "targets": [0],
                    "visible": false
                },
                {
                    "targets": [4],
                    "visible": false
                },
                {
                    "targets": [6],
                    "visible": false
                },
                {
                    "targets": [7],
                    "visible": false
                },
                {
                    "targets": [8],
                    "visible": false
                }
            ],
            fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData.active == 0) {
                    $('td', nRow).css('background-color', '#FF330B');
                }
            }
        });
        tableusr.on('search.dt', function() {
            userEmail.value = "";
            userName.value = "";
            userId.value = "";
            userNickName.value = "";
            userPhone.value = "";
        });
    }

    $('#tblUserInfo tbody').on('click', 'tr', function() {
        if ($(this).hasClass('table-active')) {
            $(this).removeClass('table-active');
        } else {
            $('#tblUserInfo tbody tr.table-active').removeClass('table-active');
            $(this).addClass('table-active');
        }

        const pos = tableusr.row(this).index();
        const row = tableusr.row(pos).data();
        userId.value = row["id"];
        userNickName.value = row["nick_name"];
        $("#role").val(row["role_name"]);
        $("#userName").val(row["name"]);
        $("#userEmail").val(row["email"]);
        user_cmb_active.checked = row["active"] === '1' ? true : false
        branch.value = row["branch"];
        userPhone.value = row["phone"]
    })

    function btnSaveOnclick(pthis) {
        if (userId.value != '') {
            if (confirm('Are you sure ?')) {
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `user/${userId.value}`,
                    data: {
                        name: userName.value,
                        email: userEmail.value,
                        active: user_cmb_active.checked ? '1' : '0',
                        role: role.value,
                        nick_name: userNickName.value,
                        branch: branch.value,
                        phone: userPhone.value,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: "JSON",
                    success: function(response) {
                        pthis.disabled = false
                        alertify.success(response.msg)
                        initdataUSRList()
                    },
                    error: function(xhr, xopt, xthrow) {
                        const respon = Object.keys(xhr.responseJSON)
                        const div_alert = document.getElementById('div-alert')
                        let msg = ''
                        for (const item of respon) {
                            msg += `<p>${xhr.responseJSON[item]}</p>`
                        }
                        div_alert.innerHTML = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    ${msg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`
                        pthis.innerHTML = `Save`
                        alertify.warning(xthrow);
                        pthis.disabled = false
                    }
                });
            }
        }
    }

    function btnResetPasswordOnclick() {
        if (userId.value.trim().length === 0) {
            alertify.warning('Please select a user from the table below')
            return
        }
        const myModal = new bootstrap.Modal(document.getElementById('resetPasswordModal'), {})
        myModal.show()
    }

    function newPasswordOnKeyPress(e) {
        let statusPW = tribinPWValidator(e.target.value)
        if (statusPW.cd === '1') {
            newPasswordInfoContainer.innerHTML = `<span class="badge bg-success">${statusPW.msg}</span>`
        } else {
            newPasswordInfoContainer.innerHTML = `<span class="badge bg-warning">${statusPW.msg}</span>`
        }
    }

    function btnConfirmResetPasswordOnClick(pthis) {
        let newpw = newPassword.value
        let newpw_c = confirmNewPassword.value
        if (newpw !== newpw_c) {
            alert('password does not match');
            confirmNewPassword.focus();
        } else {
            let statusPW = tribinPWValidator(newpw)
            if (statusPW.cd === '1') {
                newPasswordInfoContainer.innerHTML = `<span class="badge bg-success">${statusPW.msg}</span>`
            } else {
                newPasswordInfoContainer.innerHTML = `<span class="badge bg-warning">${statusPW.msg}</span>`
                confirmNewPassword.focus()
                return
            }
            if (confirm('Are you sure ?')) {
                pthis.disabled = true
                jQuery.ajax({
                    type: "PUT",
                    url: `user/reset-password/${userId.value}`,
                    dataType: "json",
                    data: {
                        newPassword: confirmNewPassword.value,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        pthis.disabled = false
                        $("#resetPasswordModal").modal('hide');
                        alertify.notify("password was reseted");
                    },
                    error: function(xhr, xopt, xthrow) {
                        const respon = Object.keys(xhr.responseJSON)
                        const div_alert = document.getElementById('div-alert2')
                        let msg = ''
                        for (const item of respon) {
                            msg += `<p>${xhr.responseJSON[item]}</p>`
                        }
                        div_alert.innerHTML = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    ${msg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`
                        pthis.innerHTML = `OK`
                        alertify.warning(xthrow);
                        pthis.disabled = false
                    }
                })
            }
        }
    }
</script>