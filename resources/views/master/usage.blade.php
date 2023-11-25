<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Usage Master</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnImport" onclick="btnShowImportDataModal()" title="Import"><i class="fas fa-file-import"></i></button>
        </div>
    </div>
</div>
<form id="usage-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Code</span>
                <input type="text" id="usageCode" class="form-control" placeholder="Usage Code" maxlength="2">
                <button class="btn btn-primary" type="button" onclick="btnShowUsageModal()"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-3 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Name</span>
                <input type="text" id="usageName" class="form-control" placeholder="Harian" maxlength="15">
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Description</span>
                <input type="text" id="usageDescription" class="form-control" placeholder="7 Jam Per Hari" maxlength="45">
            </div>
        </div>
    </div>
    <input type="hidden" id="usageInputMode" value="0">
</form>
<!-- Modal -->
<div class="modal fade" id="usageModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Usage List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="usageSearchBy" class="form-select" onchange="usageSearch.focus()">
                                    <option value="0">Code</option>
                                    <option value="1">Name</option>
                                </select>
                                <input type="text" id="usageSearch" class="form-control" maxlength="50" onkeypress="usageSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="usageTabelContainer">
                                <table id="usageTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Description</th>
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
        usageCode.value = ''
        usageCode.disabled = false
        usageCode.focus()
        tribinClearTextBox()
        usageInputMode.value = 0
    }

    function btnSaveOnclick(pthis) {
        if (usageCode.value.trim().length <= 0) {
            usageCode.focus()
            alertify.warning(`Code is required`)
            return
        }
        if (usageName.value.trim().length <= 2) {
            usageName.focus()
            alertify.warning(`Name is required`)
            return
        }
        const data = {
            MUSAGE_CD: usageCode.value.trim(),
            MUSAGE_ALIAS: usageName.value.trim(),
            MUSAGE_DESCRIPTION: usageDescription.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (usageInputMode.value === '0') {
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "usage",
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
        } else {
            if (confirm(`Are you sure want to update ?`)) {
                const data = {
                    MUSAGE_ALIAS: usageName.value.trim(),
                    MUSAGE_DESCRIPTION: usageDescription.value.trim(),
                    _token: '{{ csrf_token() }}',
                }
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "put",
                    url: `usage/${btoa(usageCode.value)}`,
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

    function btnShowUsageModal() {
        const myModal = new bootstrap.Modal(document.getElementById('usageModal'), {})
        usageModal.addEventListener('shown.bs.modal', () => {
            usageSearch.focus()
        })
        myModal.show()
    }

    function usageSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: usageSearchBy.value,
                searchValue: e.target.value,
            }
            usageTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "usage",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("usageTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = usageTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("usageTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['MUSAGE_CD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#usageModal').modal('hide')
                            usageInputMode.value = 1
                            usageCode.value = arrayItem['MUSAGE_CD']
                            usageName.value = arrayItem['MUSAGE_ALIAS']
                            usageDescription.value = arrayItem['MUSAGE_DESCRIPTION']
                            usageCode.disabled = true
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MUSAGE_ALIAS']
                        newcell = newrow.insertCell(-1)
                        newcell.innerHTML = arrayItem['MUSAGE_DESCRIPTION']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    usageTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please try again</td></tr>`
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
            url: "usage/import",
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
</script>