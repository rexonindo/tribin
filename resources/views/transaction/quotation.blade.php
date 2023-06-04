<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quotation</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="quotation-form">
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
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Condition</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label for="quotationCode" class="form-label">Quotation Code</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="quotationCode" class="form-control" placeholder="PNW..." maxlength="17" disabled>
                                        <button class="btn btn-primary" type="button" onclick="btnShowQuotationModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="quotationIssueDate" class="form-label">Issue Date</label>
                                    <input type="text" id="quotationIssueDate" class="form-control" maxlength="10" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="quotationSubject" class="form-label">Subject</label>
                                    <input type="text" id="quotationSubject" class="form-control" placeholder="Penawaran ..." maxlength="100">
                                </div>
                            </div>
                            <div class="row border-top">
                                <div class="col-md-12 mb-1">
                                    <div class="table-responsive" id="quotationTableContainer">
                                        <table id="quotationTable" class="table table-sm table-hover table-bordered caption-top">
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
                                        <input type="text" id="quotationItemCode" class="form-control quotationInputItem" placeholder="Item Code" disabled>
                                        <button class="btn btn-primary" type="button" onclick="btnShowItemModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">Item Name</span>
                                        <input type="text" id="quotationItemName" class="form-control quotationInputItem" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">Usage</span>
                                        <input type="text" id="quotationUsage" class="form-control quotationInputItem" title="price per hour">
                                        <span class="input-group-text">Hour</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">Price</span>
                                        <input type="text" id="quotationPrice" class="form-control quotationInputItem" title="price per hour">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">Operator Price</span>
                                        <input type="text" id="quotationOperator" class="form-control quotationInputItem" title="price per man">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group input-group-sm mb-1">
                                        <span class="input-group-text">MOBDEMOB</span>
                                        <input type="text" id="quotationMOBDEMOB" class="form-control quotationInputItem">
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
                                    <label for="quotationCustomer" class="form-label">Customer Name</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="quotationCustomer" class="form-control" maxlength="50" disabled>
                                        <input type="hidden" id="quotationCustomerCode">
                                        <button class="btn btn-primary" type="button" onclick="btnShowQuotationCustomerModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="quotationAttn" class="form-label">Attn.</label>
                                    <input type="text" id="quotationAttn" class="form-control" maxlength="50">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                        <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <div class="input-group mb-1">
                                        <input type="text" id="quotationCondition" class="form-control" onkeypress="quotationConditionOnKeyPress(event)" maxlength="450">
                                        <button class="btn btn-primary" type="button" onclick="addCondition()"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <h3 class="text-body-secondary">Condition List :</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <ul class="list-group list-group-flush list-group-numbered" id="quotationConditionContainer">
                                    </ul>
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
                    <button type="button" class="btn btn-outline-primary" id="btnPrint" onclick="btnPrintOnclick(this)" title="Print"><i class="fas fa-print"></i></button>
                </div>
            </div>
        </div>
        <input type="hidden" id="quotationInputMode" value="0">
    </div>

</form>
<!-- Modal -->
<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Quotation List</h1>
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
<script>
    $("#quotationIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    function quotationConditionOnKeyPress(e) {
        if (e.key === 'Enter') {
            addCondition()
        }
    }

    function addCondition() {
        const condition = quotationCondition.value.trim()
        if (condition.length > 2) {
            const liElement = document.createElement('li')
            liElement.title = "go ahead"
            liElement.classList.add(...['list-group-item', 'd-flex', 'justify-content-between', 'align-items-start'])
            const childLiElement = document.createElement('div')
            childLiElement.classList.add(...['ms-2', 'me-auto'])
            childLiElement.innerHTML = condition
            const childLiElement2 = document.createElement('span')
            childLiElement2.classList.add(...['badge', 'bg-warning', 'rounded-pill'])
            childLiElement2.innerHTML = `<i class="fas fa-trash"></i>`
            childLiElement2.style.cssText = 'cursor:pointer'
            childLiElement2.onclick = () => {
                if (confirm(`Are you sure ?`)) {
                    liElement.remove()
                }
            }
            liElement.appendChild(childLiElement)
            liElement.appendChild(childLiElement2)
            quotationConditionContainer.appendChild(liElement)
            quotationCondition.value = ``
        }
    }

    function btnShowQuotationCustomerModal() {
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
                            quotationCustomerCode.value = arrayItem['MCUS_CUSCD']
                            quotationCustomer.value = arrayItem['MCUS_CUSNM']
                            quotationAttn.focus()
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
                            quotationItemCode.value = arrayItem['MITM_ITMCD']
                            quotationItemName.value = arrayItem['MITM_ITMNM']
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
        if (quotationItemCode.value.length === 0) {
            quotationItemCode.focus()
            alertify.warning(`Item Code is required`)
            return
        }
        const quotationTableBody = quotationTable.getElementsByTagName('tbody')[0]
        newrow = quotationTableBody.insertRow(-1)
        newrow.title = 'not selected'
        newrow.onclick = (event) => {
            const selrow = quotationTable.rows[event.target.parentElement.rowIndex]
            if (selrow.title === 'selected') {
                selrow.title = 'not selected'
                selrow.classList.remove('table-info')
            } else {
                const ttlrows = quotationTable.rows.length
                for (let i = 1; i < ttlrows; i++) {
                    quotationTable.rows[i].classList.remove('table-info')
                    quotationTable.rows[i].title = 'not selected'
                }
                selrow.title = 'selected'
                selrow.classList.add('table-info')
            }
        }
        newcell = newrow.insertCell(0)
        newcell.classList.add('d-none')

        newcell = newrow.insertCell(1)
        newcell.innerHTML = quotationItemCode.value

        newcell = newrow.insertCell(2)
        newcell.innerHTML = quotationItemName.value

        newcell = newrow.insertCell(3)
        newcell.innerHTML = quotationUsage.value
        newcell.classList.add('text-center')

        newcell = newrow.insertCell(4)
        newcell.innerHTML = numeral(quotationPrice.value).format(',')
        newcell.classList.add('text-end')

        newcell = newrow.insertCell(5)
        newcell.innerHTML = numeral(quotationOperator.value).format(',')
        newcell.classList.add('text-end')

        newcell = newrow.insertCell(6)
        newcell.innerHTML = numeral(quotationMOBDEMOB.value).format(',')
        newcell.classList.add('text-end')

        tribinClearTextBoxByClassName('quotationInputItem')
    }

    function btnNewOnclick() {
        tribinClearTextBox()
        quotationTable.getElementsByTagName('tbody')[0].innerHTML = ``
        quotationConditionContainer.innerHTML = ``
    }

    function btnRemoveLineOnclick() {
        const ttlrows = quotationTable.rows.length
        for (let i = 1; i < ttlrows; i++) {
            if (quotationTable.rows[i].title === 'selected') {
                if (confirm(`Are you sure ?`)) {
                    quotationTable.rows[i].remove()
                    break;
                }
            }
        }
    }

    function btnSaveOnclick(pthis) {
        if (quotationCode.value.length === 0) {
            let itemCode = []
            let itemQty = []
            let itemUsage = []
            let itemPrice = []
            let itemOperatorPrice = []
            let itemMobDemob = []
            let quotationCondition = []
            const ttlrows = quotationTable.rows.length
            for (let i = 1; i < ttlrows; i++) {
                itemCode.push(quotationTable.rows[i].cells[1].innerText.trim())
                itemUsage.push(quotationTable.rows[i].cells[3].innerText.trim())
                itemQty.push(1)
                itemPrice.push(numeral(quotationTable.rows[i].cells[4].innerText.trim()).value())
                itemOperatorPrice.push(numeral(quotationTable.rows[i].cells[5].innerText.trim()).value())
                itemMobDemob.push(numeral(quotationTable.rows[i].cells[6].innerText.trim()).value())
            }
            if (ttlrows === 1) {
                alertify.message('nothing to be saved')
                return
            }
            if (quotationIssueDate.value.length === 0) {
                alertify.message('issue date is required')
                quotationIssueDate.focus()
                return
            }
            if (quotationSubject.value.length === 0) {
                alertify.message('Subject is required')
                quotationIssueDate.focus()
                return
            }
            let conditionList = quotationConditionContainer.getElementsByTagName('li')
            for (let i = 0; i < conditionList.length; i++) {
                quotationCondition.push(conditionList[i].innerText)
            }
            const data = {
                TQUO_CUSCD: quotationCustomerCode.value.trim(),
                TQUO_ATTN: quotationAttn.value.trim(),
                TQUO_SBJCT: quotationSubject.value.trim(),
                TQUO_ISSUDT: quotationIssueDate.value.trim(),
                TQUODETA_ITMCD: itemCode,
                TQUODETA_ITMQT: itemQty,
                TQUODETA_USAGE: itemUsage,
                TQUODETA_PRC: itemPrice,
                TQUODETA_OPRPRC: itemOperatorPrice,
                TQUODETA_MOBDEMOB: itemMobDemob,
                TQUOCOND_CONDI: quotationCondition,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to save ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "POST",
                    url: "quotation",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        quotationCode.value = response.doc
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

        }
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
                            quotationCode.value = arrayItem['TQUO_QUOCD']
                            quotationIssueDate.value = arrayItem['TQUO_ISSUDT']
                            quotationSubject.value = arrayItem['TQUO_SBJCT']
                            quotationCustomer.value = arrayItem['MCUS_CUSNM']
                            quotationCustomerCode.value = arrayItem['TQUO_CUSCD']
                            quotationAttn.value = arrayItem['TQUO_ATTN']
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
                let myContainer = document.getElementById("quotationTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = quotationTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("quotationTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.dataItem.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = quotationTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                        } else {
                            const ttlrows = quotationTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                quotationTable.rows[i].classList.remove('table-info')
                                quotationTable.rows[i].title = 'not selected'
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
                quotationConditionContainer.innerHTML = ''
                response.dataCondition.forEach((arrayItem) => {
                    const liElement = document.createElement('li')
                    liElement.title = "go ahead"
                    liElement.classList.add(...['list-group-item', 'd-flex', 'justify-content-between', 'align-items-start'])
                    const childLiElement = document.createElement('div')
                    childLiElement.classList.add(...['ms-2', 'me-auto'])
                    childLiElement.innerHTML = arrayItem['TQUOCOND_CONDI']
                    const childLiElement2 = document.createElement('span')
                    childLiElement2.classList.add(...['badge', 'bg-warning', 'rounded-pill'])
                    childLiElement2.innerHTML = `<i class="fas fa-trash"></i>`
                    childLiElement2.style.cssText = 'cursor:pointer'
                    childLiElement2.onclick = () => {
                        if (confirm(`Are you sure ?`)) {
                            liElement.remove()
                        }
                    }
                    liElement.appendChild(childLiElement)
                    liElement.appendChild(childLiElement2)
                    quotationConditionContainer.appendChild(liElement)
                    quotationCondition.value = ``
                })                
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }
</script>