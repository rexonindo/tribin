<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Item Master List</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnImport" onclick="btnShowImportDataModal()" title="Import"><i class="fas fa-file-import"></i></button>
        </div>
    </div>
</div>
<form id="item-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Code</span>
                    <input type="text" id="itemCode" class="form-control" placeholder="Item Code" aria-label="Item Code" maxlength="25" onkeypress="itemCodeOnKeyPress(event)">
                    <button class="btn btn-primary" type="button" onclick="btnShowItemModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Name</span>
                    <input type="text" id="itemName" class="form-control" placeholder="Item Name" maxlength="50">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Unit Measurement</span>
                    <select class="form-select" id="unitMeasurement" onchange="unitMeasurementOnChange()">
                        @foreach ($uoms as $uom)
                        <option value="{{ $uom->MUOM_UOMCD }}">{{ $uom->MUOM_UOMNM }}</option>                       
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Category</span>
                    <input type="text" id="itemCategory" class="form-control" placeholder="Compressor...Genset" maxlength="15">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Brand</span>
                    <input type="text" id="itemBrand" class="form-control" placeholder="Item Brand" aria-label="Item Brand" maxlength="45">
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Model</span>
                    <input type="text" id="itemModel" class="form-control" placeholder="Item Model" maxlength="45">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-6 mb-3">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Specification</span>
                    <input type="text" id="itemSpec" class="form-control" placeholder="Item Spec" aria-label="Item Spec" maxlength="50">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">COA</span>
                    <select class="form-select" id="itemCOA">
                        <option value="-" selected>-</option>
                        @foreach ($coas as $coa)
                        <option value="{{$coa->MCOA_COACD}}">{{$coa->MCOA_COANM}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mb-1">
                <h4>Item Type</h4>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="itemType" id="radio1" value="1" checked>
                    <label class="form-check-label" for="radio1">Finished Good</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="itemType" id="radio2" value="2">
                    <label class="form-check-label" for="radio2">Spare Part</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="itemType" id="radio3" value="3">
                    <label class="form-check-label" for="radio3">Services</label>
                </div>
            </div>
        </div>
        <input type="hidden" id="itemInputMode" value="0">
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="itemModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Item List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="itemSearchBy" class="form-select" onchange="itemSearch.focus()">
                                    <option value="0">Item Code</option>
                                    <option value="1">Item Name</option>
                                    <option value="2">Specification</option>
                                </select>
                                <input type="text" id="itemSearch" class="form-control" placeholder="Item Search" aria-label="Item Search" maxlength="50" onkeypress="itemSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="itemTabelContainer">
                                <table id="itemTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Item Type</th>
                                            <th>UM</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Specification</th>
                                            <th>Category</th>
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
    function itemSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: itemSearchBy.value,
                searchValue: e.target.value,
            }
            itemTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="8">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "item",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("itemTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = itemTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("itemTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['MITM_ITMCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#itemModal').modal('hide')
                            itemInputMode.value = 1
                            itemCode.value = arrayItem['MITM_ITMCD']
                            itemName.value = arrayItem['MITM_ITMNM']
                            unitMeasurement.value = arrayItem['MITM_STKUOM']
                            itemBrand.value = arrayItem['MITM_BRAND']
                            itemModel.value = arrayItem['MITM_MODEL']
                            itemSpec.value = arrayItem['MITM_SPEC']
                            itemCategory.value = arrayItem['MITM_ITMCAT']
                            itemCOA.value = arrayItem['MITM_COACD']
                            switch (arrayItem['MITM_ITMTYPE']) {
                                case '1':
                                    radio1.checked = true;
                                    break
                                case '2':
                                    radio2.checked = true;
                                    break
                                case '3':
                                    radio3.checked = true;
                                    break
                            }
                            itemCode.disabled = true
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MITM_ITMNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MITM_ITMTYPE']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['MITM_STKUOM']
                        newcell = newrow.insertCell(4)
                        newcell.innerHTML = arrayItem['MITM_BRAND']
                        newcell = newrow.insertCell(5)
                        newcell.innerHTML = arrayItem['MITM_MODEL']
                        newcell = newrow.insertCell(6)
                        newcell.innerHTML = arrayItem['MITM_SPEC']
                        newcell = newrow.insertCell(7)
                        newcell.innerHTML = arrayItem['MITM_ITMCAT']
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

    function importDatasCompany(pthis) {
        if (!confirm('Are you sure ?')) {
            return
        }
        pthis.disabled = true
        pthis.innerHTML = `Please wait...`
        $.ajax({
            type: "POST",
            url: "item/import",
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

    function btnShowItemModal() {
        const myModal = new bootstrap.Modal(document.getElementById('itemModal'), {})
        itemModal.addEventListener('shown.bs.modal', () => {
            itemSearch.focus()
        })
        myModal.show()
    }

    function btnNewOnclick() {
        itemCode.value = ''
        itemCode.disabled = false
        itemCode.focus()
        tribinClearTextBox()
        itemInputMode.value = 0
    }

    function itemCodeOnKeyPress(e) {
        if (e.key === 'Enter') {
            itemName.focus()
        }
    }

    function unitMeasurementOnChange() {
        btnSave.focus()
    }

    function btnSaveOnclick(pthis) {
        if (itemCode.value.trim().length <= 3) {
            itemCode.focus()
            alertify.warning(`Item Code is required`)
            return
        }
        if (itemName.value.trim().length <= 3) {
            itemName.focus()
            alertify.warning(`Item Name is required`)
            return
        }
        const data = {
            MITM_ITMCD: itemCode.value.trim(),
            MITM_ITMNM: itemName.value.trim(),
            MITM_STKUOM: unitMeasurement.value.trim(),
            MITM_ITMTYPE: document.querySelector("input[type='radio'][name=itemType]:checked").value,
            MITM_BRAND: itemBrand.value.trim(),
            MITM_MODEL: itemModel.value.trim(),
            MITM_SPEC: itemSpec.value.trim(),
            MITM_ITMCAT: itemCategory.value.trim(),
            MITM_COACD: itemCOA.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (itemInputMode.value === '0') {
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "item",
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
                    MITM_ITMNM: itemName.value.trim(),
                    MITM_STKUOM: unitMeasurement.value.trim(),
                    MITM_ITMTYPE: document.querySelector("input[type='radio'][name=itemType]:checked").value,
                    MITM_BRAND: itemBrand.value.trim(),
                    MITM_MODEL: itemModel.value.trim(),
                    MITM_SPEC: itemSpec.value.trim(),
                    MITM_COACD: itemCOA.value.trim(),
                    _token: '{{ csrf_token() }}',
                }
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "put",
                    url: `item/${btoa(itemCode.value)}`,
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
    function btnShowImportDataModal() {
        const myModal = new bootstrap.Modal(document.getElementById('itemImportModal'), {})        
        myModal.show()
    }
</script>