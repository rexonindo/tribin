<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Condition Master</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnImport" onclick="btnShowImportDataModal()" title="Import"><i class="fas fa-file-import"></i></button>
            <button type="button" class="btn btn-outline-danger" id="btnDelete" onclick="btnDeleteOnClick(this)" title="Delete"><i class="fas fa-trash"></i></button>
        </div>
    </div>
</div>
<form id="condition-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Code</span>
                <input type="text" id="conditionCode" class="form-control" placeholder="Condition Code" maxlength="7">
                <button class="btn btn-primary" type="button" onclick="btnShowConditionModal()"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Name</span>
                <input type="text" id="conditionName" class="form-control" placeholder="Condition Name" maxlength="50">
            </div>
        </div>
    </div>
    <input type="hidden" id="conditionInputMode" value="0">
    <input type="hidden" id="conditionId" value="0">
</form>
<!-- Modal -->
<div class="modal fade" id="conditionModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Condition List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="conditionSearchBy" class="form-select" onchange="conditionSearch.focus()">
                                    <option value="0">Code</option>
                                    <option value="1">Name</option>
                                </select>
                                <input type="text" id="conditionSearch" class="form-control" maxlength="50" onkeypress="conditionSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="conditionTabelContainer">
                                <table id="conditionTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
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
<div class="modal fade" id="itemImportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Import Data Master</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1" id="div-alert-import">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Source</span>
                                <select id="fromConnection" class="form-select">
                                    @foreach ($companies as $r)
                                    <option value="{{$r->connection}}">{{$r->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Destination</span>
                                <select class="form-select" disabled>
                                    @foreach ($CurrentCompanies as $r)
                                    <option value="{{$r->connection}}">{{$r->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="importDatasCompany(this)">Import</button>
            </div>
        </div>
    </div>
</div>
<script>
    function btnNewOnclick() {
        conditionCode.value = ''
        conditionId.value = 0
        conditionCode.disabled = false
        conditionCode.focus()
        tribinClearTextBox()
        conditionInputMode.value = 0
    }

    function btnSaveOnclick(pthis) {
        if (conditionCode.value.trim().length <= 0) {
            conditionCode.focus()
            alertify.warning(`Code is required`)
            return
        }
        if (conditionName.value.trim().length <= 2) {
            conditionName.focus()
            alertify.warning(`Name is required`)
            return
        }
        const data = {
            MCONDITION_ORDER_NUMBER: conditionCode.value.trim(),
            MCONDITION_DESCRIPTION: conditionName.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (conditionInputMode.value === '0') {
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "condition",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        pthis.disabled = false
                        conditionId.value = response.id
                        document.getElementById('div-alert').innerHTML = ''
                        conditionInputMode.value = 1
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
                const data = {
                    MCONDITION_ORDER_NUMBER: conditionCode.value.trim(),
                    MCONDITION_DESCRIPTION: conditionName.value.trim(),
                    _token: '{{ csrf_token() }}',
                }
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "put",
                    url: `condition/${btoa(conditionId.value)}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        pthis.disabled = false
                        document.getElementById('div-alert').innerHTML = ''
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

    function btnShowConditionModal() {
        const myModal = new bootstrap.Modal(document.getElementById('conditionModal'), {})
        conditionModal.addEventListener('shown.bs.modal', () => {
            conditionSearch.focus()
        })
        myModal.show()
    }

    function conditionSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: conditionSearchBy.value,
                searchValue: e.target.value,
            }
            conditionTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="2">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "condition/search",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("conditionTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = conditionTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("conditionTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['MCONDITION_ORDER_NUMBER']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#conditionModal').modal('hide')
                            conditionInputMode.value = 1
                            conditionCode.value = arrayItem['MCONDITION_ORDER_NUMBER']
                            conditionName.value = arrayItem['MCONDITION_DESCRIPTION']
                            conditionId.value = arrayItem['id']
                            conditionInputMode.value = 1
                            conditionTabel.getElementsByTagName('tbody')[0].innerHTML = ''
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCONDITION_DESCRIPTION']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    conditionTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="2">Please try again</td></tr>`
                }
            });
        }
    }

    function btnShowImportDataModal() {
        const myModal = new bootstrap.Modal(document.getElementById('itemImportModal'), {})
        myModal.show()
    }

    function importDatasCompany(pthis) {
        if (!confirm('Are you sure ?')) {
            return
        }
        pthis.disabled = true
        pthis.innerHTML = `Please wait...`
        $.ajax({
            type: "POST",
            url: "condition/import",
            data: {
                fromConnection: fromConnection.value,
                _token: '{{ csrf_token() }}',
            },
            dataType: "json",
            success: function(response) {
                pthis.disabled = false
                pthis.innerHTML = `Import`
                alert(response.message)
            },
            error: function(xhr, xopt, xthrow) {
                const respon = Object.keys(xhr.responseJSON)
                const div_alert = document.getElementById('div-alert-import')
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

    function btnDeleteOnClick(pthis) {
        if(conditionId.value == 0) {
            alertify.warning('there is nothing to be deleted')
            return
        }
        if (confirm(`Are you sure want to delete ?`)) {
            const data = {
                _token: '{{ csrf_token() }}',
            }
            pthis.innerHTML = `Please wait...`
            pthis.disabled = true
            $.ajax({
                type: "delete",
                url: `condition/${btoa(conditionId.value)}`,
                data: data,
                dataType: "json",
                success: function(response) {
                    pthis.innerHTML = `<i class="fas fa-trash"></i>`
                    alertify.success(response.msg)
                    pthis.disabled = false
                    document.getElementById('div-alert').innerHTML = ''
                    btnNewOnclick()
                },
                error: function(xhr, xopt, xthrow) {
                    pthis.innerHTML = `<i class="fas fa-trash"></i>`
                    pthis.disabled = false
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
                    alertify.warning(xthrow);
                }
            });
        }
    }
</script>