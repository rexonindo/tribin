<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Receive Order</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="order-form">
    <div class="container">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Item</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-users-rectangle"></i> Customer</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label for="orderCode" class="form-label">Code</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="orderCode" class="form-control" placeholder="RO..." maxlength="17" disabled>
                                        <button class="btn btn-primary" type="button" onclick="btnShowReceiveModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label for="orderIssueDate" class="form-label">Issue Date</label>
                                    <input type="text" id="orderIssueDate" class="form-control" maxlength="10" readonly>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label for="orderPlanDeliveryDate" class="form-label">Plan Delivery Date</label>
                                    <input type="text" id="orderPlanDeliveryDate" class="form-control" maxlength="10" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="orderQuotation" class="form-label">Quotation Code</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="orderQuotation" class="form-control" placeholder="PNW..." disabled>
                                        <button class="btn btn-primary" type="button" onclick="btnShowQuotationModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="orderPONumber" class="form-label">PO Number</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="orderPONumber" class="form-control" placeholder="" maxlength="50">
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top">
                                <div class="col-md-12 mb-1">
                                    <div class="table-responsive" id="orderTableContainer">
                                        <table id="orderTable" class="table table-sm table-hover table-bordered caption-top">
                                            <caption>List of items</caption>
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="d-none">idLine</th>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th class="text-center">Usage</th>
                                                    <th class="text-end">Price</th>
                                                    <th class="text-end">Operator</th>
                                                    <th class="text-end">MOB DEMOB</th>
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
                                        <input type="text" id="orderItemCode" class="form-control orderInputItem" placeholder="Item Code" disabled>
                                        <button class="btn btn-primary" type="button" onclick="btnShowItemModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">Item Name</span>
                                        <input type="text" id="orderItemName" class="form-control orderInputItem" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">Usage</span>
                                        <input type="text" id="orderUsage" class="form-control orderInputItem" title="price per hour">
                                        <span class="input-group-text">Hour</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">Price</span>
                                        <input type="text" id="orderPrice" class="form-control orderInputItem" title="price per hour">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">Operator Price</span>
                                        <input type="text" id="orderOperator" class="form-control orderInputItem" title="price per man">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">MOBDEMOB</span>
                                        <input type="text" id="orderMOBDEMOB" class="form-control orderInputItem">
                                    </div>
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
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                        <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label for="orderCustomer" class="form-label">Customer Name</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="orderCustomer" class="form-control" maxlength="50" disabled>
                                        <input type="hidden" id="orderCustomerCode">
                                        <button class="btn btn-primary" type="button" onclick="btnShowReceiveCustomerModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="orderAttn" class="form-label">Attn.</label>
                                    <input type="text" id="orderAttn" class="form-control" maxlength="50">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col mt-1 mb-1">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)" title="New"><i class="fas fa-file"></i></button>
                    <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
                </div>
            </div>
        </div>
        <input type="hidden" id="orderInputMode" value="0">
    </div>

</form>
<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Receive List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="orderSearchBy" class="form-select" onchange="orderSearch.focus()">
                                    <option value="0">Order Code</option>
                                    <option value="1">Customer</option>
                                    <option value="2">PO Number</option>
                                </select>
                                <input type="text" id="orderSearch" class="form-control" maxlength="50" onkeypress="orderSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="orderSavedTabelContainer">
                                <table id="orderSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Issue Date</th>
                                            <th>Quotation</th>
                                            <th>PO Number</th>
                                            <th>Delivery Plan Date</th>
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
<!-- Customer Modal -->
<div class="modal fade" id="customerModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Customer List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="customerSearchBy" class="form-select" onchange="customerSearch.focus()">
                                    <option value="0">Customer Code</option>
                                    <option value="1">Customer Name</option>
                                    <option value="2">Address</option>
                                </select>
                                <input type="text" id="customerSearch" class="form-control" maxlength="50" onkeypress="customerSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="customerTabelContainer">
                                <table id="customerTabel" class="table table-sm table-striped table-bordered table-hover">
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
<!-- Modal -->
<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Approved Quotation List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="quotationSearchBy" class="form-select" onchange="quotationSearch.focus()">
                                    <option value="0">Quotation Code</option>
                                    <option value="1">Customer</option>
                                </select>
                                <input type="text" id="quotationSearch" class="form-control" maxlength="50" onkeypress="quotationSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="quotationSavedTabelContainer">
                                <table id="quotationSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Issue Date</th>
                                            <th>Subject</th>
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
    $("#orderIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    $("#orderPlanDeliveryDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    function btnShowReceiveCustomerModal() {
        const myModal = new bootstrap.Modal(document.getElementById('customerModal'), {})
        customerModal.addEventListener('shown.bs.modal', () => {
            customerSearch.focus()
        })
        myModal.show()
    }

    function customerSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: customerSearchBy.value,
                searchValue: e.target.value,
            }
            customerTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "customer",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("customerTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = customerTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("customerTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['MCUS_CUSCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#customerModal').modal('hide')
                            orderCustomerCode.value = arrayItem['MCUS_CUSCD']
                            orderCustomer.value = arrayItem['MCUS_CUSNM']
                            orderAttn.focus()
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCUS_CUSNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MCUS_CURCD']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['MCUS_TAXREG']
                        newcell = newrow.insertCell(4)
                        newcell.innerHTML = arrayItem['MCUS_ADDR1']
                        newcell = newrow.insertCell(5)
                        newcell.innerHTML = arrayItem['MCUS_TELNO']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    customerTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please try again</td></tr>`
                }
            });
        }
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
                            orderItemCode.value = arrayItem['MITM_ITMCD']
                            orderItemName.value = arrayItem['MITM_ITMNM']
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
        if (orderItemCode.value.length === 0) {
            orderItemCode.focus()
            alertify.warning(`Item Code is required`)
            return
        }
        const orderTableBody = orderTable.getElementsByTagName('tbody')[0]
        newrow = orderTableBody.insertRow(-1)
        newrow.title = 'not selected'
        newrow.onclick = (event) => {
            const selrow = orderTable.rows[event.target.parentElement.rowIndex]
            if (selrow.title === 'selected') {
                selrow.title = 'not selected'
                selrow.classList.remove('table-info')
            } else {
                const ttlrows = orderTable.rows.length
                for (let i = 1; i < ttlrows; i++) {
                    orderTable.rows[i].classList.remove('table-info')
                    orderTable.rows[i].title = 'not selected'
                }
                selrow.title = 'selected'
                selrow.classList.add('table-info')
            }
        }
        newcell = newrow.insertCell(0)
        newcell.classList.add('d-none')

        newcell = newrow.insertCell(1)
        newcell.innerHTML = orderItemCode.value

        newcell = newrow.insertCell(2)
        newcell.innerHTML = orderItemName.value

        newcell = newrow.insertCell(3)
        newcell.innerHTML = orderUsage.value
        newcell.classList.add('text-center')

        newcell = newrow.insertCell(4)
        newcell.innerHTML = numeral(orderPrice.value).format(',')
        newcell.classList.add('text-end')

        newcell = newrow.insertCell(5)
        newcell.innerHTML = numeral(orderOperator.value).format(',')
        newcell.classList.add('text-end')

        newcell = newrow.insertCell(6)
        newcell.innerHTML = numeral(orderMOBDEMOB.value).format(',')
        newcell.classList.add('text-end')

        tribinClearTextBoxByClassName('orderInputItem')
    }

    function btnNewOnclick() {
        tribinClearTextBox()
        orderTable.getElementsByTagName('tbody')[0].innerHTML = ``
    }

    function btnRemoveLineOnclick(pthis) {
        const ttlrows = orderTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (orderTable.rows[i].title === 'selected') {
                idItem = orderTable.rows[i].cells[0].innerText.trim()
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
                        url: `receive-order/items/${idItem}`,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Remove line`
                            pthis.disabled = false
                            orderTable.rows[iFounded].remove()
                            alertify.message(response.msg)
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Remove line`
                        }
                    });
                } else {
                    orderTable.rows[iFounded].remove()
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function btnSaveOnclick(pthis) {
        let itemCode = []
        let itemQty = []
        let itemUsage = []
        let itemPrice = []
        let itemOperatorPrice = []
        let itemMobDemob = []
        const ttlrows = orderTable.rows.length
        for (let i = 1; i < ttlrows; i++) {
            itemCode.push(orderTable.rows[i].cells[1].innerText.trim())
            itemUsage.push(orderTable.rows[i].cells[3].innerText.trim())
            itemQty.push(1)
            itemPrice.push(numeral(orderTable.rows[i].cells[4].innerText.trim()).value())
            itemOperatorPrice.push(numeral(orderTable.rows[i].cells[5].innerText.trim()).value())
            itemMobDemob.push(numeral(orderTable.rows[i].cells[6].innerText.trim()).value())
        }
        if (ttlrows === 1) {
            alertify.message('nothing to be saved')
            return
        }
        if (orderIssueDate.value.length === 0) {
            alertify.message('issue date is required')
            orderIssueDate.focus()
            return
        }

        if (orderPlanDeliveryDate.value.trim().length <= 1) {
            alertify.message('Plan Delivery date is required')
            orderPlanDeliveryDate.focus()
            return
        }
        if (orderCode.value.length === 0) {
            if (orderPONumber.value.trim().length <= 1) {                
                if(!confirm('Leave PO from Customer blank ?')){
                    orderPONumber.focus()
                    return
                }
            }
            const data = {
                TSLO_CUSCD: orderCustomerCode.value.trim(),
                TSLO_ATTN: orderAttn.value.trim(),
                TSLO_QUOCD: orderQuotation.value.trim(),
                TSLO_POCD: orderPONumber.value.trim(),
                TSLO_ISSUDT: orderIssueDate.value.trim(),
                TSLO_PLAN_DLVDT: orderPlanDeliveryDate.value.trim(),
                TSLODETA_ITMCD: itemCode,
                TSLODETA_ITMQT: itemQty,
                TSLODETA_USAGE: itemUsage,
                TSLODETA_PRC: itemPrice,
                TSLODETA_OPRPRC: itemOperatorPrice,
                TSLODETA_MOBDEMOB: itemMobDemob,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to save ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "POST",
                    url: "receive-order",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        orderCode.value = response.doc
                        loadReceiveDetail({
                            doc: response.doc
                        })
                        pthis.disabled = false
                        document.getElementById('div-alert').innerHTML = ''
                        orderPONumber.value = response.newPOCode
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
                TSLO_CUSCD: orderCustomerCode.value.trim(),
                TSLO_ATTN: orderAttn.value.trim(),
                TSLO_POCD: orderPONumber.value.trim(),
                TSLO_ISSUDT: orderIssueDate.value.trim(),
                TSLO_PLAN_DLVDT: orderPlanDeliveryDate.value.trim(),
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to update ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `receive-order/${btoa(orderCode.value)}`,
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

    function btnShowReceiveModal() {
        const myModal = new bootstrap.Modal(document.getElementById('orderModal'), {})
        orderModal.addEventListener('shown.bs.modal', () => {
            orderSearch.focus()
        })
        myModal.show()
    }

    function orderSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: orderSearchBy.value,
                searchValue: e.target.value,
            }
            orderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "receive-order",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("orderSavedTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = orderSavedTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("orderSavedTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['TSLO_SLOCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#orderModal').modal('hide')
                            orderCode.value = arrayItem['TSLO_SLOCD']
                            orderIssueDate.value = arrayItem['TSLO_ISSUDT']
                            orderQuotation.value = arrayItem['TSLO_QUOCD']
                            orderPONumber.value = arrayItem['TSLO_POCD']
                            orderCustomer.value = arrayItem['MCUS_CUSNM']
                            orderCustomerCode.value = arrayItem['TSLO_CUSCD']
                            orderAttn.value = arrayItem['TSLO_ATTN']
                            orderPlanDeliveryDate.value = arrayItem['TSLO_PLAN_DLVDT']
                            loadReceiveDetail({
                                doc: arrayItem['TSLO_SLOCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCUS_CUSNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TSLO_ISSUDT']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['TSLO_QUOCD']
                        newcell = newrow.insertCell(4)
                        newcell.innerHTML = arrayItem['TSLO_POCD']
                        newcell = newrow.insertCell(5)
                        newcell.innerHTML = arrayItem['TSLO_PLAN_DLVDT']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    orderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6"></td></tr>`
                }
            });
        }
    }

    function loadReceiveDetail(data) {
        $.ajax({
            type: "GET",
            url: `receive-order/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                let myContainer = document.getElementById("orderTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = orderTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("orderTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.dataItem.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = orderTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                        } else {
                            const ttlrows = orderTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                orderTable.rows[i].classList.remove('table-info')
                                orderTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['TSLODETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-center')
                    newcell.innerHTML = arrayItem['TSLODETA_USAGE']
                    newcell = newrow.insertCell(4)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TSLODETA_PRC']).format(',')
                    newcell = newrow.insertCell(5)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TSLODETA_OPRPRC']).format(',')
                    newcell = newrow.insertCell(6)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TSLODETA_MOBDEMOB']).format(',')
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function btnShowQuotationModal() {
        const myModal = new bootstrap.Modal(document.getElementById('quotationModal'), {})
        quotationModal.addEventListener('shown.bs.modal', () => {
            quotationSearch.focus()
        })
        myModal.show()
    }

    function quotationSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: quotationSearchBy.value,
                searchValue: e.target.value,
                approval: '1',
            }
            quotationSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "quotation",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("quotationSavedTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = quotationSavedTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("quotationSavedTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['TQUO_QUOCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#quotationModal').modal('hide')
                            orderQuotation.value = arrayItem['TQUO_QUOCD']
                            orderCustomer.value = arrayItem['MCUS_CUSNM']
                            orderCustomerCode.value = arrayItem['TQUO_CUSCD']
                            orderAttn.value = arrayItem['TQUO_ATTN']
                            loadQuotationDetail({
                                doc: arrayItem['TQUO_QUOCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCUS_CUSNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TQUO_ISSUDT']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['TQUO_SBJCT']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    quotationSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4"></td></tr>`
                }
            });
        }
    }

    function loadQuotationDetail(data) {
        $.ajax({
            type: "GET",
            url: `quotation/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                let myContainer = document.getElementById("orderTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = orderTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("orderTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.dataItem.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = orderTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                        } else {
                            const ttlrows = orderTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                orderTable.rows[i].classList.remove('table-info')
                                orderTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['TQUODETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-center')
                    newcell.innerHTML = arrayItem['TQUODETA_USAGE']
                    newcell = newrow.insertCell(4)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TQUODETA_PRC']).format(',')
                    newcell = newrow.insertCell(5)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TQUODETA_OPRPRC']).format(',')
                    newcell = newrow.insertCell(6)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TQUODETA_MOBDEMOB']).format(',')
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }
</script>