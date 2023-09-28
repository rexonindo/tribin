<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Distance Price Master</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnImport" onclick="btnShowImportDataModal()" title="Import"><i class="fas fa-file-import"></i></button>
        </div>
    </div>
</div>
<form id="coa-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Range From</span>
                <input type="number" id="RangeFrom" class="form-control">
                <button class="btn btn-primary" type="button" onclick="btnShowCoaModal()"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Range To</span>
                <input type="text" id="RangeTo" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">4 & 6 Wheels Price</span>
                <input type="number" id="Price4" class="form-control">
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">10 Wheels Price</span>
                <input type="number" id="Price10" class="form-control">
            </div>
        </div>
    </div>
    <input type="hidden" id="coaInputMode" value="0">
</form>
<!-- Modal -->
<div class="modal fade" id="coaModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="coaSearchBy" class="form-select" onchange="coaSearch.focus()">
                                    <option value="0">Range From</option>
                                </select>
                                <input type="text" id="coaSearch" class="form-control" maxlength="50" onkeypress="coaSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="coaTabelContainer">
                                <table id="coaTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Range From</th>
                                            <th>Range To</th>
                                            <th>4 & 6 wheels price</th>
                                            <th>10 wheels price</th>
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
        RangeFrom.value = ''
        RangeFrom.disabled = false
        RangeFrom.focus()
        tribinClearTextBox()
        coaInputMode.value = 0
    }

    function btnSaveOnclick(pthis) {
        if (RangeFrom.value.trim().length <= 0) {
            RangeFrom.focus()
            alertify.warning(`Range From is required`)
            return
        }
        if (RangeTo.value.trim().length <= 0) {
            RangeTo.focus()
            alertify.warning(`Range To is required`)
            return
        }
        const data = {
            RANGE1: RangeFrom.value.trim(),
            RANGE2: RangeTo.value.trim(),
            PRICE_WHEEL_4_AND_6: Price4.value.trim(),
            PRICE_WHEEL_10: Price10.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (coaInputMode.value === '0') {
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "distance-price",
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
                    PRICE_WHEEL_4_AND_6: Price4.value.trim(),
                    PRICE_WHEEL_10: Price10.value.trim(),
                    _token: '{{ csrf_token() }}',
                }
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "put",
                    url: `distance-price/${btoa(RangeFrom.value)}`,
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

    function btnShowCoaModal() {
        const myModal = new bootstrap.Modal(document.getElementById('coaModal'), {})
        coaModal.addEventListener('shown.bs.modal', () => {
            coaSearch.focus()
        })
        myModal.show()
    }

    function coaSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: coaSearchBy.value,
                searchValue: e.target.value,
            }
            coaTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "distance-price",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("coaTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = coaTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("coaTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['RANGE1']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#coaModal').modal('hide')
                            coaInputMode.value = 1
                            RangeFrom.value = arrayItem['RANGE1']
                            RangeTo.value = arrayItem['RANGE2']
                            Price4.value = arrayItem['PRICE_WHEEL_4_AND_6']
                            Price10.value = arrayItem['PRICE_WHEEL_10']
                            RangeFrom.disabled = true
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['RANGE2']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['PRICE_WHEEL_4_AND_6']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['PRICE_WHEEL_10']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    coaTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please try again</td></tr>`
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
            url: "distance-price/import",
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