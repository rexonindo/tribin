<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Purchase Request</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="purchaseRequest-form">
    <div class="container">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <label for="purchaseRequestCode" class="form-label">Purchase Request Code</label>
                <div class="input-group mb-1">
                    <input type="text" id="purchaseRequestCode" class="form-control" placeholder="PCR..." maxlength="17" disabled>
                    <button class="btn btn-primary" type="button" onclick="btnShowPurchaseModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label for="purchaseRequestIssueDate" class="form-label">Issue Date</label>
                <input type="text" id="purchaseRequestIssueDate" class="form-control" maxlength="10" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Purpose</span>
                    <input type="text" class="form-control" id="purpose" list="purposeList">
                    <datalist id="purposeList">
                        <option value="Bengkel">
                        <option value="Kendaraan">
                        <option value="Perawatan Mesin">
                        <option value="Perlengkapan Kantor">
                    </datalist>
                </div>
            </div>
        </div>
        <div class="row border-top">
            <div class="col-md-12 mb-1">
                <div class="table-responsive" id="purchaseRequestTableContainer">
                    <table id="purchaseRequestTable" class="table table-sm table-hover table-bordered caption-top">
                        <caption>List of items</caption>
                        <thead class="table-light">
                            <tr>
                                <th class="d-none">idLine</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th class="text-end">Qty</th>
                                <th class="text-center">Required Date</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Code</span>
                    <input type="text" id="purchaseRequestItemCode" class="form-control purchaseRequestInputItem" placeholder="Item Code" disabled>
                    <button class="btn btn-primary" type="button" onclick="btnShowItemModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Name</span>
                    <input type="text" id="purchaseRequestItemName" class="form-control purchaseRequestInputItem" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-1">
                <label class="form-label">Qty</label>
                <input type="text" id="purchaseRequestQty" class="form-control form-control-sm purchaseRequestInputItem">
            </div>
            <div class="col-md-4 mb-1">
                <label for="purchaseRequestRequiredDate" class="form-label">Required Date</label>
                <input type="text" id="purchaseRequestRequiredDate" class="form-control form-control-sm purchaseRequestInputItem" maxlength="10" readonly>
            </div>
            <div class="col-md-4 mb-1">
                <label for="purchaseRequestRemark" class="form-label">Remark</label>
                <input type="text" id="purchaseRequestRemark" class="form-control form-control-sm purchaseRequestInputItem" maxlength="255">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-1 text-center">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" id="btnSaveLine" onclick="btnSaveLineOnclick(this)">Save line</button>
                    <button type="button" class="btn btn-outline-secondary" id="btnRemoveLine" onclick="btnRemoveLineOnclick(this)">Remove line</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col mt-1 mb-1">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)" title="New"><i class="fas fa-file"></i></button>
                    <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
                    <button type="button" class="btn btn-outline-primary" id="btnPrint" onclick="btnPrintOnclick(this)" title="Print"><i class="fas fa-print"></i></button>
                </div>
            </div>
        </div>
        <input type="hidden" id="purchaseRequestInputMode" value="0">
    </div>

</form>
<!-- Modal -->
<div class="modal fade" id="purchaseRequestModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Purchase Request List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="purchaseRequestSearchBy" class="form-select" onchange="purchaseRequestSearch.focus()">
                                    <option value="0">Document Number</option>
                                    <option value="1">Purpose</option>
                                </select>
                                <input type="text" id="purchaseRequestSearch" class="form-control" maxlength="50" onkeypress="purchaseRequestSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="purchaseRequestSavedTabelContainer">
                                <table id="purchaseRequestSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Document Number</th>
                                            <th>Issue Date</th>
                                            <th>Purpose</th>
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
<!-- Item Modal -->
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
                                    <option value="1">Item Name</option>
                                    <option value="0">Item Code</option>
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
<script>
    $("#purchaseRequestIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    $("#purchaseRequestRequiredDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5',
        size: 'small'
    })

    function btnShowPurchaseModal() {
        const myModal = new bootstrap.Modal(document.getElementById('purchaseRequestModal'), {})
        purchaseRequestModal.addEventListener('shown.bs.modal', () => {
            purchaseRequestSearch.focus()
        })
        myModal.show()
    }

    function btnShowItemModal() {
        const myModal = new bootstrap.Modal(document.getElementById('itemModal'), {})
        itemModal.addEventListener('shown.bs.modal', () => {
            itemSearch.focus()
        })
        myModal.show()
    }

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
                            purchaseRequestItemCode.value = arrayItem['MITM_ITMCD']
                            purchaseRequestItemName.value = arrayItem['MITM_ITMNM']
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

    function btnSaveLineOnclick() {
        if (purchaseRequestItemCode.value.length === 0) {
            purchaseRequestItemCode.focus()
            alertify.warning(`Item Code is required`)
            return
        }

        if (purchaseRequestRequiredDate.value.length === 0) {
            purchaseRequestRequiredDate.focus()
            alertify.warning(`Required Date is required`)
            return
        }
        if (purchaseRequestCode.value.length > 1) {
            const data = {
                TPCHREQ_PCHCD: purchaseRequestCode.value,
                TPCHREQDETA_ITMCD: purchaseRequestItemCode.value,
                TPCHREQDETA_ITMQT: purchaseRequestQty.value,
                TPCHREQDETA_REQDT: purchaseRequestRequiredDate.value,
                TPCHREQDETA_REMARK: purchaseRequestRemark.value,
                _token: '{{ csrf_token() }}',
            }
            $.ajax({
                type: "POST",
                url: "purchase-request",
                data: data,
                dataType: "JSON",
                success: function(response) {
                    loadPurchaseRequestDetail({
                        doc: purchaseRequestCode.value
                    })
                }
            });
        } else {
            const purchaseRequestTableBody = purchaseRequestTable.getElementsByTagName('tbody')[0]

            newrow = purchaseRequestTableBody.insertRow(-1)
            newrow.title = 'not selected'
            newrow.onclick = (event) => {
                const selrow = purchaseRequestTable.rows[event.target.parentElement.rowIndex]
                if (selrow.title === 'selected') {
                    selrow.title = 'not selected'
                    selrow.classList.remove('table-info')
                } else {
                    const ttlrows = purchaseRequestTable.rows.length
                    for (let i = 1; i < ttlrows; i++) {
                        purchaseRequestTable.rows[i].classList.remove('table-info')
                        purchaseRequestTable.rows[i].title = 'not selected'
                    }
                    selrow.title = 'selected'
                    selrow.classList.add('table-info')
                }
            }
            newcell = newrow.insertCell(0)
            newcell.classList.add('d-none')

            newcell = newrow.insertCell(1)
            newcell.innerHTML = purchaseRequestItemCode.value

            newcell = newrow.insertCell(2)
            newcell.innerHTML = purchaseRequestItemName.value

            newcell = newrow.insertCell(3)
            newcell.innerHTML = purchaseRequestQty.value
            newcell.classList.add('text-end')

            newcell = newrow.insertCell(4)
            newcell.innerHTML = purchaseRequestRequiredDate.value
            newcell.classList.add('text-center')

            newcell = newrow.insertCell(5)
            newcell.innerHTML = purchaseRequestRemark.value
        }
        tribinClearTextBoxByClassName('purchaseRequestInputItem')
    }

    function btnSaveOnclick(pthis) {
        let itemCode = []
        let itemQty = []
        let itemRequiredDate = []
        let itemRemark = []

        const ttlrows = purchaseRequestTable.rows.length
        for (let i = 1; i < ttlrows; i++) {
            itemCode.push(purchaseRequestTable.rows[i].cells[1].innerText.trim())
            itemQty.push(purchaseRequestTable.rows[i].cells[3].innerText.trim())
            itemRequiredDate.push(purchaseRequestTable.rows[i].cells[4].innerText.trim())
            itemRemark.push(purchaseRequestTable.rows[i].cells[5].innerText.trim())
        }
        if (ttlrows === 0) {
            alertify.message('nothing to be saved')
            return
        }
        if (purchaseRequestIssueDate.value.length === 0) {
            alertify.message('issue date is required')
            purchaseRequestIssueDate.focus()
            return
        }

        if (purchaseRequestCode.value.length === 0) {
            const data = {
                TPCHREQ_PURPOSE: purpose.value.trim(),
                TPCHREQ_ISSUDT: purchaseRequestIssueDate.value.trim(),
                TPCHREQDETA_ITMCD: itemCode,
                TPCHREQDETA_ITMQT: itemQty,
                TPCHREQDETA_REQDT: itemRequiredDate,
                TPCHREQDETA_REMARK: itemRemark,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to save ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "POST",
                    url: "purchase-request",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        purchaseRequestCode.value = response.doc
                        loadPurchaseRequestDetail({
                            doc: response.doc
                        })
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
            const data = {
                TPCHREQ_PURPOSE: purpose.value.trim(),
                TPCHREQ_ISSUDT: purchaseRequestIssueDate.value.trim(),
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to update ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `purchase-request/${btoa(purchaseRequestCode.value)}`,
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

    function loadPurchaseRequestDetail(data) {
        $.ajax({
            type: "GET",
            url: `purchase-request/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                let myContainer = document.getElementById("purchaseRequestTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = purchaseRequestTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("purchaseRequestTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.dataItem.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = purchaseRequestTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                        } else {
                            const ttlrows = purchaseRequestTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                purchaseRequestTable.rows[i].classList.remove('table-info')
                                purchaseRequestTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['TPCHREQDETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TPCHREQDETA_ITMQT']
                    newcell = newrow.insertCell(4)
                    newcell.classList.add('text-center')
                    newcell.innerHTML = arrayItem['TPCHREQDETA_REQDT']
                    newcell = newrow.insertCell(5)
                    newcell.innerHTML = arrayItem['TPCHREQDETA_REMARK']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function purchaseRequestSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: purchaseRequestSearchBy.value,
                searchValue: e.target.value,
            }
            purchaseRequestSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "purchase-request",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("purchaseRequestSavedTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = purchaseRequestSavedTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("purchaseRequestSavedTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['TPCHREQ_PCHCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#purchaseRequestModal').modal('hide')
                            purchaseRequestCode.value = arrayItem['TPCHREQ_PCHCD']
                            purchaseRequestIssueDate.value = arrayItem['TPCHREQ_ISSUDT']
                            loadPurchaseRequestDetail({
                                doc: arrayItem['TPCHREQ_PCHCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['TPCHREQ_ISSUDT']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TPCHREQ_PURPOSE']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    purchaseRequestSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3"></td></tr>`
                }
            });
        }
    }

    function btnRemoveLineOnclick(pthis) {
        const ttlrows = purchaseRequestTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (purchaseRequestTable.rows[i].title === 'selected') {
                idItem = purchaseRequestTable.rows[i].cells[0].innerText.trim()
                iFounded = i
                break
            }
        }

        if (iFounded > 0) {
            if (confirm(`Are you sure ?`)) {
                if (idItem.length >= 1) {
                    pthis.disabled = true
                    pthis.innerHTML = `Please wait`
                    $.ajax({
                        type: "DELETE",
                        url: `purchase-request/items/${idItem}`,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Remove line`
                            pthis.disabled = false
                            purchaseRequestTable.rows[iFounded].remove()
                            alertify.message(response.msg)
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Remove line`
                        }
                    });
                } else {
                    purchaseRequestTable.rows[iFounded].remove()
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function btnPrintOnclick(pthis) {
        if (purchaseRequestCode.value.trim().length === 0) {
            alertify.message('Purchase Request Document is required')
            purchaseRequestCode.focus()
            return
        }
        window.open(`PDF/purchase-request/${btoa(purchaseRequestCode.value)}`, '_blank');
    }
</script>