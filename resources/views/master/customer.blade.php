<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Customer Master</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="customer-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Customer Code</span>
                <input type="text" id="customerCode" class="form-control" placeholder="Customer Code" aria-label="Customer Code" maxlength="10">
                <button class="btn btn-primary" type="button" onclick="btnShowCustomerModal()"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Customer Name</span>
                <input type="text" id="customerName" class="form-control" placeholder="Customer Name" maxlength="50">
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
                <input type="text" id="customerTax" class="form-control" placeholder="" maxlength="45">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Address</span>
                <textarea id="customerAddress" class="form-control" placeholder="Jalan..."></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Telephone</span>
                <input type="text" id="customerTelephone" class="form-control" placeholder="021..." maxlength="20">
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
        <div class="col mb-1">
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
                <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
            </div>
        </div>
    </div>
    <input type="hidden" id="customerInputMode" value="0">
</form>
<!-- Modal -->
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
<script>
    function btnNewOnclick() {
        customerCode.value = ''
        customerCode.disabled = false
        customerCode.focus()
        tribinClearTextBox()
        customerInputMode.value = 0
        companyGroup.value = '-'
    }

    function btnSaveOnclick(pthis) {
        if (customerCode.value.trim().length <= 3) {
            customerCode.focus()
            alertify.warning(`Customer Code is required`)
            return
        }
        if (customerName.value.trim().length <= 3) {
            customerName.focus()
            alertify.warning(`Customer Name is required`)
            return
        }
        const data = {
            MCUS_CUSCD: customerCode.value.trim(),
            MCUS_CUSNM: customerName.value.trim(),
            MCUS_CURCD: currency.value.trim(),
            MCUS_TAXREG: customerTax.value.trim(),
            MCUS_ADDR1: customerAddress.value.trim(),
            MCUS_TELNO: customerTelephone.value.trim(),
            MCUS_CGCON: companyGroup.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (customerInputMode.value === '0') {
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "customer",
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
                    MCUS_CUSNM: customerName.value.trim(),
                    MCUS_CURCD: currency.value.trim(),
                    MCUS_TAXREG: customerTax.value.trim(),
                    MCUS_ADDR1: customerAddress.value.trim(),
                    MCUS_TELNO: customerTelephone.value.trim(),
                    MCUS_CGCON: companyGroup.value.trim(),
                    _token: '{{ csrf_token() }}',
                }
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "put",
                    url: `customer/${btoa(customerCode.value)}`,
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

    function btnShowCustomerModal() {
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
                            customerInputMode.value = 1
                            customerCode.value = arrayItem['MCUS_CUSCD']
                            customerName.value = arrayItem['MCUS_CUSNM']
                            currency.value = arrayItem['MCUS_CURCD']
                            customerTax.value = arrayItem['MCUS_TAXREG']
                            customerAddress.value = arrayItem['MCUS_ADDR1']
                            customerTelephone.value = arrayItem['MCUS_TELNO']
                            companyGroup.value = arrayItem['MCUS_CGCON']
                            customerCode.disabled = true
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
</script>