<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Supplier Master List</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnImport" onclick="btnShowImportDataModal()" title="Import"><i class="fas fa-file-import"></i></button>
        </div>
    </div>
</div>
<form id="supplier-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Supplier Code</span>
                <input type="text" id="supplierCode" class="form-control" placeholder="Supplier Code" aria-label="Supplier Code" maxlength="10">
                <button class="btn btn-primary" type="button" onclick="btnShowSupplierModal()"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Supplier Name</span>
                <input type="text" id="supplierName" class="form-control" placeholder="Suppplier Name" maxlength="50">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Currency</span>
                <select class="form-select" id="currency">
                    <option value="IDR">IDR</option>
                    <option value="USD">USD</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Tax Registration Number</span>
                <input type="text" id="supplierTax" class="form-control" placeholder="" maxlength="45">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Address</span>
                <textarea id="supplierAddress" class="form-control" placeholder="Jalan..."></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Telephone</span>
                <input type="text" id="supplierTelephone" class="form-control" placeholder="021..." maxlength="20">
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
    <input type="hidden" id="supplierInputMode" value="0">
</form>
<!-- Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Supplier List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="supplierSearchBy" class="form-select" onchange="supplierSearch.focus()">
                                    <option value="0">Supplier Code</option>
                                    <option value="1">Supplier Name</option>
                                    <option value="2">Address</option>
                                </select>
                                <input type="text" id="supplierSearch" class="form-control" maxlength="50" onkeypress="supplierSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="supplierTabelContainer">
                                <table id="supplierTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Currency</th>
                                            <th>Tax Reg. Number</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
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
        supplierCode.value = ''
        supplierCode.disabled = false
        supplierCode.focus()
        tribinClearTextBox()
        supplierInputMode.value = 0
    }

    function btnSaveOnclick(pthis) {
        if (supplierCode.value.trim().length <= 3) {
            supplierCode.focus()
            alertify.warning(`Supplier Code is required`)
            return
        }
        if (supplierName.value.trim().length <= 3) {
            supplierName.focus()
            alertify.warning(`Supplier Name is required`)
            return
        }
        const data = {
            MSUP_SUPCD: supplierCode.value.trim(),
            MSUP_SUPNM: supplierName.value.trim(),
            MSUP_CURCD: currency.value.trim(),
            MSUP_TAXREG: supplierTax.value.trim(),
            MSUP_ADDR1: supplierAddress.value.trim(),
            MSUP_TELNO: supplierTelephone.value.trim(),
            MSUP_CGCON: companyGroup.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (supplierInputMode.value === '0') {
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "supplier",
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
                    MSUP_SUPNM: supplierName.value.trim(),
                    MSUP_CURCD: currency.value.trim(),
                    MSUP_TAXREG: supplierTax.value.trim(),
                    MSUP_ADDR1: supplierAddress.value.trim(),
                    MSUP_TELNO: supplierTelephone.value.trim(),
                    MSUP_CGCON: companyGroup.value.trim(),
                    _token: '{{ csrf_token() }}',
                }
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "put",
                    url: `supplier/${btoa(supplierCode.value)}`,
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

    function btnShowSupplierModal() {
        const myModal = new bootstrap.Modal(document.getElementById('supplierModal'), {})
        supplierModal.addEventListener('shown.bs.modal', () => {
            supplierSearch.focus()
        })
        myModal.show()
    }

    function supplierSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: supplierSearchBy.value,
                searchValue: e.target.value,
            }
            supplierTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "supplier",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("supplierTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = supplierTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("supplierTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['MSUP_SUPCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#supplierModal').modal('hide')
                            supplierInputMode.value = 1
                            supplierCode.value = arrayItem['MSUP_SUPCD']
                            supplierName.value = arrayItem['MSUP_SUPNM']
                            currency.value = arrayItem['MSUP_CURCD']
                            supplierTax.value = arrayItem['MSUP_TAXREG']
                            supplierAddress.value = arrayItem['MSUP_ADDR1']
                            supplierTelephone.value = arrayItem['MSUP_TELNO']
                            companyGroup.value = arrayItem['MSUP_CGCON']
                            supplierCode.disabled = true
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MSUP_SUPNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MSUP_CURCD']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['MSUP_TAXREG']
                        newcell = newrow.insertCell(4)
                        newcell.innerHTML = arrayItem['MSUP_ADDR1']
                        newcell = newrow.insertCell(5)
                        newcell.innerHTML = arrayItem['MSUP_TELNO']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    supplierTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please try again</td></tr>`
                }
            });
        }
    }

    function importDatasCompany(pthis) {
        if (!confirm('Are you sure ?')) {
            return
        }
        pthis.disabled = true
        pthis.innerHTML = `Please wait...`
        $.ajax({
            type: "POST",
            url: "supplier/import",
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

    function btnShowImportDataModal() {
        const myModal = new bootstrap.Modal(document.getElementById('itemImportModal'), {})
        myModal.show()
    }
</script>