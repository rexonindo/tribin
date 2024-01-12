<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Company Information</h1>
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
                            <i class="fa-solid fa-house fa-stack-1x"></i>
                        </span>
                        General Info
                    </button>
                    <button class="nav-link" id="nav-access-tab" data-bs-toggle="tab" data-bs-target="#nav-access" type="button" role="tab">
                        <span class="fa-stack" style="vertical-align: top;">
                            <i class="fa-regular fa-circle fa-stack-2x"></i>
                            <i class="fa-solid fa-building-columns fa-stack-1x"></i>
                        </span>
                        Payment Account
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
                                    <input type="text" id="companyName" class="form-control" placeholder="Company Name" maxlength="65" value="{{ $SelectedCompany ? $SelectedCompany->name : '' }}">
                                    <input type="hidden" id="companyId" value="{{ $SelectedCompany ? $SelectedCompany->id : '-' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Address</span>
                                    <textarea class="form-control" id="companyAddress" maxlength="200">{{ $SelectedCompany ? $SelectedCompany->address : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Phone</span>
                                    <input type="text" id="companyPhone" class="form-control" placeholder="+0..." maxlength="45" value="{{ $SelectedCompany ? $SelectedCompany->phone : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="input-group input-group-sm mb-1">
                                    <span class="input-group-text">Fax</span>
                                    <input type="text" id="companyFax" class="form-control" placeholder="+0..." maxlength="45" value="{{ $SelectedCompany ? $SelectedCompany->fax : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="companyInvoiceNumber" class="form-label">Invoice Number Pattern</label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" id="companyInvoiceNumber" class="form-control" maxlength="15" placeholder="JP/INV  or JC/INV" value="{{ $SelectedCompany ? $SelectedCompany->invoice_letter_id : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="companyQuotationNumber" class="form-label">Quotation Number Pattern</label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" id="companyQuotationNumber" class="form-control" maxlength="15" placeholder="PT/PNW  or CV/PNW" value="{{ $SelectedCompany ? $SelectedCompany->quotation_letter_id : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <label for="companyLetterHead" class="form-label">Letter Head</label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" id="companyLetterHead" class="form-control" maxlength="55" value="{{ $SelectedCompany ? $SelectedCompany->letter_head : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-1">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-access" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="companyBankName" class="form-label">BANK</label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" id="companyBankName" class="form-control" maxlength="75">
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="companyBankName" class="form-label">Account Name</label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" id="companyAccountName" class="form-control" maxlength="75">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <label for="companyAccountNumber" class="form-label">Account Number</label>
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" id="companyAccountNumber" class="form-control" maxlength="75">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1 text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary" id="btnSaveAccess" onclick="btnSaveAccessOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
                                    <button type="button" class="btn btn-outline-warning" id="btnRemoveAccess" onclick="btnRemoveAccessOnclick(this)" title="Delete"><i class="fas fa-trash"></i></button>
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
                                                <th>Bank</th>
                                                <th>Account Name</th>
                                                <th>Account Number</th>
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
<script>
    function btnSaveOnclick(pthis) {
        pthis.disabled = true
        pthis.innerHTML = `Please wait...`
        const data = {
            name: companyName.value,
            address: companyAddress.value,
            phone: companyPhone.value,
            fax: companyFax.value,
            invoice_letter_id: companyInvoiceNumber.value,
            quotation_letter_id: companyQuotationNumber.value,
            letter_head: companyLetterHead.value,
            _token: '{{ csrf_token() }}',
        }
        $.ajax({
            type: "PUT",
            url: `company/management-form/${companyId.value}`,
            data: data,
            dataType: "json",
            success: function(response) {
                pthis.innerHTML = `<i class="fas fa-save"></i>`
                alertify.success(response.msg)
                companyId.value = response.id
                pthis.disabled = false
                document.getElementById('div-alert').innerHTML = ''
            },
            error: function(xhr, xopt, xthrow) {
                pthis.innerHTML = `<i class="fas fa-save"></i>`
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

    function btnSaveAccessOnclick(pthis) {
        pthis.disabled = true
        pthis.innerHTML = `Please wait...`
        const data = {
            bank_name: companyBankName.value,
            bank_account_name: companyAccountName.value,
            bank_account_number: companyAccountNumber.value,
            _token: '{{ csrf_token() }}',
        }
        $.ajax({
            type: "POST",
            url: `payment-account/form`,
            data: data,
            dataType: "json",
            success: function(response) {
                pthis.innerHTML = `<i class="fas fa-save"></i>`
                alertify.success(response.msg)
                companyId.value = response.id
                pthis.disabled = false
                document.getElementById('div-alert').innerHTML = ''
                getAccounts()
            },
            error: function(xhr, xopt, xthrow) {
                pthis.innerHTML = `<i class="fas fa-save"></i>`
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

    getAccounts()

    function getAccounts() {
        $.ajax({
            type: "GET",
            url: "payment-account",
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
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['bank_name']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['bank_account_name']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['bank_account_number']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
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
                alertify.warning(xthrow);
            }
        });
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
        if (confirm(`Are you sure want to remove account ${idItem} in ${idItem2} ?`)) {
            pthis.innerHTML = `Please wait`
            $.ajax({
                type: "DELETE",
                url: `payment-account/form/${id}`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(response) {
                    pthis.innerHTML = `<i class="fas fa-trash"></i>`
                    alertify.success(response.msg)
                    pthis.disabled = false
                    document.getElementById('div-alert').innerHTML = ''
                    getAccounts()
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