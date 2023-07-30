<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Company Group</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="company-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-registeration-tab" data-bs-toggle="tab" data-bs-target="#nav-registeration" type="button" role="tab">
                        <span class="fa-stack" style="vertical-align: top;">
                            <i class="fa-regular fa-circle fa-stack-2x"></i>
                            <i class="fa-solid fa-1 fa-stack-1x"></i>
                        </span>
                        Registration
                    </button>
                    <button class="nav-link" id="nav-access-tab" data-bs-toggle="tab" data-bs-target="#nav-access" type="button" role="tab">
                        <span class="fa-stack" style="vertical-align: top;">
                            <i class="fa-regular fa-circle fa-stack-2x"></i>
                            <i class="fa-solid fa-2 fa-stack-1x"></i>
                        </span>
                        Access
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-registeration" role="tabpanel" tabindex="0">
                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Name</span>
                                    <input type="text" id="companyName" class="form-control" placeholder="Company Name" maxlength="65">
                                    <input type="hidden" id="companyId">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Connection</span>
                                    <select class="form-select" id="companyConnection">
                                        <option value="-" selected>-</option>
                                        @foreach ($connections as $r)
                                        <option value="{{$r}}">{{$r}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Address</span>
                                    <textarea class="form-control" id="companyAddress" maxlength="200"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Phone</span>
                                    <input type="text" id="companyPhone" class="form-control" placeholder="+0..." maxlength="45">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Fax</span>
                                    <input type="text" id="companyFax" class="form-control" placeholder="+0..." maxlength="45">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Alias Code</span>
                                    <input type="text" id="companyAliasCode" class="form-control" maxlength="3">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Alias Group Code</span>
                                    <input type="text" id="companyAliasGroupCode" class="form-control" maxlength="5">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-1">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
                                    <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <table id="registeredTable" class="table table-sm table-striped table-bordered" style="width:100%;height:100%;cursor:pointer">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Connection</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Fax</th>
                                            <th>Alias Code</th>
                                            <th>Alias Group Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-access" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <input type="hidden" id="userNickName">
                                    <span class="input-group-text">User email</span>
                                    <input type="text" id="userEmail" class="form-control" disabled>
                                    <button class="btn btn-primary" type="button" onclick="btnShowUserModal()"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Company</span>
                                    <select class="form-select" id="companyGroup">
                                        <option value="-" selected>-</option>
                                        @foreach ($companies as $r)
                                        <option value="{{$r->connection}}">{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Role</span>
                                    <select class="form-select" id="companyGroupUserRole">
                                        @foreach ($roles as $r)
                                        <option value="{{$r->name}}">{{$r->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1 text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary" id="btnSaveAccess" onclick="btnSaveAccessOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
                                    <button type="button" class="btn btn-outline-warning" id="btnRemoveAccess" onclick="btnRemoveAccessOnclick(this)" title="Revoke">Revoke</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="table-responsive" id="accessTabelContainer">
                                    <table id="accessTabel" class="table table-sm table-striped table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="d-none">id</th>
                                                <th>Email</th>
                                                <th>Company Name</th>
                                                <th class="d-none">RoleId</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">User List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="userSearchBy" class="form-select" onchange="userSearch.focus()">
                                    <option value="0">Email</option>
                                    <option value="1">Name</option>
                                </select>
                                <input type="text" id="userSearch" class="form-control" maxlength="50" onkeypress="userSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="userTabelContainer">
                                <table id="userTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Email</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var varRegisteredTable = $('#registeredTable').DataTable();
    initRegisteredTable()

    function initRegisteredTable() {
        varRegisteredTable = $('#registeredTable').DataTable({
            select: true,
            destroy: true,
            scrollX: true,
            ajax: '/company',
            columns: [{
                    "data": 'id'
                },
                {
                    "data": 'name'
                },
                {
                    "data": 'connection'
                },
                {
                    "data": 'address'
                },
                {
                    "data": 'phone'
                },
                {
                    "data": 'fax'
                },
                {
                    "data": 'alias_code'
                },
                {
                    "data": 'alias_group_code'
                },
            ],
            columnDefs: [{
                "targets": [0],
                "visible": false
            }]
        });
        varRegisteredTable.on('search.dt', function() {
            companyName.value = ''
            companyId.value = ''
            companyConnection.value = '-'
            companyAddress.value = "";
            companyPhone.value = ''
            companyFax.value = ''
        });
    }

    function btnNewOnclick() {
        companyName.focus()
        tribinClearTextBox()
        initRegisteredTable()
        companyId.value = ""
    }

    function btnSaveOnclick(pthis) {
        if (companyName.value.trim().length <= 3) {
            alertify.warning('Company Name is required')
            companyName.focus()
            return
        }
        const data = {
            name: companyName.value.trim(),
            address: companyAddress.value.trim(),
            connection: companyConnection.value.trim(),
            phone: companyPhone.value.trim(),
            fax: companyFax.value.trim(),
            alias_code: companyAliasCode.value.trim(),
            alias_group_code: companyAliasGroupCode.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (companyId.value == "") {
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "company",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        pthis.disabled = false
                        document.getElementById('div-alert').innerHTML = ''
                        initRegisteredTable()
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
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.warning(xthrow);
                        pthis.disabled = false
                    }
                });
            }
        } else {
            if (confirm(`Are you sure want to update ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "put",
                    url: `company/${btoa(companyId.value)}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        pthis.disabled = false
                        document.getElementById('div-alert').innerHTML = ''
                        initRegisteredTable()
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
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.warning(xthrow);
                        pthis.disabled = false
                    }
                });
            }
        }
    }

    $('#registeredTable tbody').on('click', 'tr', function() {
        if ($(this).hasClass('table-active')) {
            $(this).removeClass('table-active');
        } else {
            $('#registeredTable tbody tr.table-active').removeClass('table-active');
            $(this).addClass('table-active');
        }

        const pos = varRegisteredTable.row(this).index();
        const row = varRegisteredTable.row(pos).data();
        if (row) {
            companyId.value = row["id"];
            companyName.value = row["name"];
            companyConnection.value = row["connection"];
            companyAddress.value = row["address"];
            companyPhone.value = row["phone"];
            companyFax.value = row["fax"];
            companyAliasCode.value = row["alias_code"];
            companyAliasGroupCode.value = row["alias_group_code"];
        }
    });

    function btnShowUserModal() {
        const myModal = new bootstrap.Modal(document.getElementById('userModal'), {})
        userModal.addEventListener('shown.bs.modal', () => {
            userSearch.focus()
        })
        myModal.show()
    }

    function userSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: userSearchBy.value,
                searchValue: e.target.value,
            }
            userTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="2">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "user",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("userTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = userTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("userTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['email']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#userModal').modal('hide')
                            userEmail.value = arrayItem['email']
                            userNickName.value = arrayItem['nick_name']
                            loadDetail({
                                nick_name: arrayItem['nick_name']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['name']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                }
            });
        }
    }

    function loadDetail(data) {
        accessTabel.getElementsByTagName("tbody")[0].innerHTML = `<tr><td colspan="4" class="text-center">Please wait</td></tr>`
        $.ajax({
            type: "GET",
            url: `company/access/${btoa(data.nick_name)}`,
            dataType: "json",
            success: function(response) {
                let myContainer = document.getElementById("accessTabelContainer");
                let myfrag = document.createDocumentFragment();
                let cln = accessTabel.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("accessTabel");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = accessTabel.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                        } else {
                            const ttlrows = accessTabel.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                accessTabel.rows[i].classList.remove('table-info')
                                accessTabel.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['email']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['name']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['role_name']
                    newcell = newrow.insertCell(4)
                    newcell.innerHTML = arrayItem['description']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
                accessTabel.getElementsByTagName("tbody")[0].innerHTML = `<tr><td colspan="4" class="text-center">${xthrow}</td></tr>`
            }
        });
    }

    function btnSaveAccessOnclick(pthis) {
        if (userNickName.value.length === 0) {
            userNickName.focus()
            alertify.warning('Email is required')
            return
        }
        if (companyGroup.value === '-') {
            alertify.warning('select connection')
            companyGroup.focus()
            return
        }        
        const data = {
            'nick_name': userNickName.value,
            'connection': companyGroup.value,
            'role_name': companyGroupUserRole.value,
            _token: '{{ csrf_token() }}',
        }
        if (confirm(`Are you sure ?`)) {
            pthis.innerHTML = `Please wait...`
            pthis.disabled = true
            $.ajax({
                type: "post",
                url: "company/access",
                data: data,
                dataType: "json",
                success: function(response) {
                    pthis.innerHTML = `<i class="fas fa-save"></i>`
                    alertify.success(response.msg)
                    pthis.disabled = false
                    document.getElementById('div-alert').innerHTML = ''
                    loadDetail({
                        nick_name: userNickName.value
                    })
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
                    pthis.innerHTML = `<i class="fas fa-save"></i>`
                    alertify.warning(xthrow);
                    pthis.disabled = false
                }
            });
        }
    }

    function btnRemoveAccessOnclick(pthis) {
        const ttlrows = accessTabel.rows.length
        let idItem = ''
        let idItem2 = ''
        let id = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (accessTabel.rows[i].title === 'selected') {
                id = accessTabel.rows[i].cells[0].innerText.trim()
                idItem = accessTabel.rows[i].cells[1].innerText.trim()
                idItem2 = accessTabel.rows[i].cells[2].innerText.trim()
                iFounded = i
                break
            }
        }

        if (iFounded === 0) {
            alertify.warning('select a row from the table below')
            return
        }
        if (confirm(`Are you sure want to remove access ${idItem} in ${idItem2} ?`)) {
            pthis.innerHTML = `Please wait`
            $.ajax({
                type: "DELETE",
                url: `company/access/${id}`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(response) {
                    pthis.innerHTML = `Revoke`
                    alertify.success(response.msg)
                    pthis.disabled = false
                    document.getElementById('div-alert').innerHTML = ''
                    loadDetail({
                        nick_name: userNickName.value
                    })
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
                    pthis.innerHTML = `Revoke`
                    alertify.warning(xthrow);
                    pthis.disabled = false
                }
            });
        }
    }
</script>