<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Customer Master</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnImport" onclick="btnShowImportDataModal()" title="Import"><i class="fas fa-file-import"></i></button>
        </div>
    </div>
</div>
<form id="customer-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="customerType" id="radio1" value="1" checked>
                <label class="form-check-label" for="radio1">Personal</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="customerType" id="radio2" value="2">
                <label class="form-check-label" for="radio2">Corporate</label>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Reference</span>
                <input type="text" id="customerReference" class="form-control" maxlength="70">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Customer Code</span>
                <input type="text" id="customerCode" class="form-control" placeholder="Customer Code" aria-label="Customer Code" maxlength="10" readonly disabled>
                <button class="btn btn-primary" type="button" onclick="btnShowCustomerModal()"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-4 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Customer Name</span>
                <input type="text" id="customerName" class="form-control" placeholder="Customer Name" maxlength="50">
            </div>
        </div>
        <div class="col-md-4 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Group</span>
                <input type="text" id="customerGroup" class="form-control" placeholder="Customer Group" maxlength="70">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Currency</span>
                <select class="form-select" id="currency">
                    <option value="IDR">IDR</option>
                    <option value="USD">USD</option>
                </select>
            </div>
        </div>
        <div class="col-md-5 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Tax Registration Number</span>
                <input type="text" id="customerTax" class="form-control" placeholder="" maxlength="45" title="NPWP">
            </div>
        </div>
        <div class="col-md-4 mb-1">
            <div class="input-group input-group-sm mb-1">
                <label class="input-group-text" for="customerKTPNumber">ID Card</label>
                <input type="text" class="form-control" id="customerKTPNumber" maxlength="25" title="KTP">
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
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Telephone</span>
                <input type="text" id="customerTelephone" class="form-control" placeholder="021..." maxlength="20">
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Connector</span>
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
        <div class="col-md-4 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text" title="Person in charge">PIC</span>
                <input type="text" id="customerPerson" class="form-control" maxlength="70">
            </div>
        </div>
        <div class="col-md-4 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text" title="Person in charge">Phone</span>
                <input type="text" id="customerPersonPhone" class="form-control" maxlength="20">
            </div>
        </div>
        <div class="col-md-4 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text" title="Person in charge">Email</span>
                <input type="email" id="customerEmail" class="form-control" maxlength="70">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mb-1">
            <h4>Required File</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-1">
            <div class="input-group input-group-sm mb-1">
                <label class="input-group-text" for="customerKTPFile">KTP</label>
                <input type="file" class="form-control" id="customerKTPFile" accept="image/*,.pdf" onchange="customerKTPFileOnChange(event)">
            </div>
        </div>
        <div class="col-md-7 mb-1">
            <div class="input-group input-group-sm mb-1">
                <label class="input-group-text" for="customerKTPFilePath"><i class="fas fa-file"></i> </label>
                <input type="text" class="form-control" id="customerKTPFilePath" readonly disabled>
                <button class="btn btn-primary" type="button" onclick="btnShowKTPFFile()"><i class="fas fa-eye"></i></button>
                <button class="btn btn-outline-primary btnChangeFile" type="button" onclick="btnChangeKTPFile(this)" title="Change file" disabled><i class="fas fa-pencil"></i></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-1">
            <div class="input-group input-group-sm mb-1">
                <label class="input-group-text" for="customerNPWPFile">NPWP</label>
                <input type="file" class="form-control" id="customerNPWPFile" accept="image/*,.pdf" onchange="customerNPWPFileOnChange(event)">
            </div>
        </div>
        <div class="col-md-7 mb-1">
            <div class="input-group input-group-sm mb-1">
                <label class="input-group-text" for="customerNPWPFilePath"><i class="fas fa-file"></i> </label>
                <input type="text" class="form-control" id="customerNPWPFilePath" readonly disabled>
                <button class="btn btn-primary" type="button" onclick="btnShowNPWPFile()"><i class="fas fa-eye"></i></button>
                <button class="btn btn-outline-primary btnChangeFile" type="button" onclick="btnChangeNPWPFile(this)" title="Change file" disabled><i class="fas fa-pencil"></i></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-1">
            <div class="input-group input-group-sm mb-1">
                <label class="input-group-text" for="customerNIBFile">NIB</label>
                <input type="file" class="form-control" id="customerNIBFile" accept="image/*,.pdf" onchange="customerNIBFileOnChange(event)">
            </div>
        </div>
        <div class="col-md-7 mb-1">
            <div class="input-group input-group-sm mb-1">
                <label class="input-group-text" for="customerNIBFilePath"><i class="fas fa-file"></i> </label>
                <input type="text" class="form-control" id="customerNIBFilePath" readonly disabled>
                <button class="btn btn-primary" type="button" onclick="btnShowNIBFile()"><i class="fas fa-eye"></i></button>
                <button class="btn btn-outline-primary btnChangeFile" type="button" onclick="btnChangeNIBFile(this)" title="Change file" disabled><i class="fas fa-pencil"></i></button>
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
<div class="modal fade" id="customerImportModal" tabindex="-1">
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
        customerCode.value = ''
        customerCode.focus()
        tribinClearTextBox()
        customerInputMode.value = 0
        companyGroup.value = '-'
    }

    function setButtonDisabled(status, requiredClassName) {
        let buttonList = document.getElementsByClassName(requiredClassName)
        let buttonLength = buttonList.length
        for (let i = 0; i < buttonLength; i++) {
            buttonList[i].disabled = status
        }
    }

    function btnSaveOnclick(pthis) {
        const customerTypeValue = document.querySelector("input[type='radio'][name=customerType]:checked").value

        if (customerName.value.trim().length <= 3) {
            customerName.focus()
            alertify.warning(`Customer Name is required`)
            return
        }

        if (customerInputMode.value === '0') {
            const formData = new FormData()
            formData.append('MCUS_CUSNM', customerName.value.trim())
            formData.append('MCUS_CURCD', currency.value.trim())
            formData.append('MCUS_TAXREG', customerTax.value.trim())
            formData.append('MCUS_ADDR1', customerAddress.value.trim())
            formData.append('MCUS_TELNO', customerTelephone.value.trim())
            formData.append('MCUS_CGCON', companyGroup.value.trim())
            formData.append('MCUS_TYPE', customerTypeValue)
            formData.append('MCUS_GROUP', customerGroup.value.trim())
            formData.append('MCUS_REFF_MKT', customerReference.value.trim())
            formData.append('MCUS_PIC_NAME', customerPerson.value.trim())
            formData.append('MCUS_PIC_TELNO', customerPersonPhone.value.trim())
            formData.append('MCUS_EMAIL', customerEmail.value.trim())
            formData.append('MCUS_KTP_FILE', customerKTPFile.files[0])
            formData.append('MCUS_NPWP_FILE', customerNPWPFile.files[0])
            formData.append('MCUS_NIB_FILE', customerNIBFile.files[0])
            formData.append('MCUS_IDCARD', customerKTPNumber.value)
            formData.append('_token', '{{ csrf_token() }}')
            if (customerTypeValue === '1') {
                if (customerKTPFile.files.length === 0) {
                    customerKTPFile.focus()
                    alertify.warning(`KTP file is required`)
                    return
                }
                if (customerNPWPFile.files.length === 0) {
                    customerNPWPFile.focus()
                    alertify.warning(`NPWP file is required`)
                    return
                }
            } else {
                if (customerKTPFile.files.length === 0) {
                    customerKTPFile.focus()
                    alertify.warning(`KTP file is required`)
                    return
                }
                if (customerNPWPFile.files.length === 0) {
                    customerNPWPFile.focus()
                    alertify.warning(`NPWP file is required`)
                    return
                }
                if (customerNIBFile.files.length === 0) {
                    customerNIBFile.focus()
                    alertify.warning(`NIB file is required`)
                    return
                }
            }
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "customer",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        pthis.disabled = false
                        document.getElementById('div-alert').innerHTML = ''
                        setButtonDisabled(false, 'btnChangeFile')
                        customerCode.value = response.MCUS_CUSCD
                        customerKTPFilePath.value = response.MCUS_KTP_FILE
                        customerNPWPFilePath.value = response.MCUS_NPWP_FILE
                        customerNIBFilePath.value = response.MCUS_NIB_FILE
                        customerInputMode.value = 1
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
                    MCUS_TYPE: customerTypeValue,
                    MCUS_GROUP: customerGroup.value,
                    MCUS_REFF_MKT: customerReference.value,
                    MCUS_PIC_NAME: customerPerson.value,
                    MCUS_PIC_TELNO: customerPersonPhone.value,
                    MCUS_EMAIL: customerEmail.value,
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

    function importDatasCompany(pthis) {
        if (!confirm('Are you sure ?')) {
            return
        }
        pthis.disabled = true
        pthis.innerHTML = `Please wait...`
        $.ajax({
            type: "POST",
            url: "customer/import",
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

    function btnShowCustomerModal() {
        const myModal = new bootstrap.Modal(document.getElementById('customerModal'), {})
        customerModal.addEventListener('shown.bs.modal', () => {
            customerSearch.focus()
        })
        myModal.show()
    }

    function btnShowImportDataModal() {
        const myModal = new bootstrap.Modal(document.getElementById('customerImportModal'), {})        
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
                            customerGroup.value = arrayItem['MCUS_GROUP']
                            currency.value = arrayItem['MCUS_CURCD']
                            customerTax.value = arrayItem['MCUS_TAXREG']
                            customerAddress.value = arrayItem['MCUS_ADDR1']
                            customerTelephone.value = arrayItem['MCUS_TELNO']
                            companyGroup.value = arrayItem['MCUS_CGCON']
                            customerReference.value = arrayItem['MCUS_REFF_MKT']
                            customerPerson.value = arrayItem['MCUS_PIC_NAME']
                            customerPersonPhone.value = arrayItem['MCUS_PIC_TELNO']
                            customerEmail.value = arrayItem['MCUS_EMAIL']
                            customerKTPFilePath.value = arrayItem['MCUS_KTP_FILE']
                            customerNPWPFilePath.value = arrayItem['MCUS_NPWP_FILE']
                            customerNIBFilePath.value = arrayItem['MCUS_NIB_FILE']
                            customerCode.disabled = true
                            switch (arrayItem['MCUS_TYPE']) {
                                case '1':
                                    radio1.checked = true;
                                    break;
                                case '2':
                                    radio2.checked = true;
                                    break;
                            }
                            setButtonDisabled(false, 'btnChangeFile')
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

    function customerKTPFileOnChange(e) {
        customerKTPFilePath.value = e.target.files[0].name
    }

    function customerNPWPFileOnChange(e) {
        customerNPWPFilePath.value = e.target.files[0].name
    }

    function customerNIBFileOnChange(e) {
        customerNIBFilePath.value = e.target.files[0].name
    }

    function btnShowKTPFFile() {
        if (customerKTPFilePath.value.length > 5) {
            window.open(`/customer/file/${customerKTPFilePath.value}`, '_blank')
        } else {
            alert('there is no file to view')
        }
    }

    function btnShowNPWPFile() {
        if (customerNPWPFilePath.value.length > 5) {
            window.open(`/customer/file/${customerNPWPFilePath.value}`, '_blank')
        } else {
            alert('there is no file to view')
        }
    }

    function btnShowNIBFile() {
        if (customerNIBFilePath.value.length > 5) {
            window.open(`/customer/file/${customerNIBFilePath.value}`, '_blank')
        } else {
            alert('there is no file to view')
        }
    }

    function btnChangeKTPFile(firstSenderObject) {
        if (customerKTPFile.files.length === 0) {
            customerKTPFile.focus()
            alertify.warning(`KTP file is required`)
            return
        }
        changeFile('MCUS_KTP_FILE', customerKTPFile.files[0], firstSenderObject, customerKTPFilePath)
    }

    function changeFile(fieldName, fileToSent, senderObject, fixedFileNameContainer) {
        const formData = new FormData()
        formData.append(fieldName, fileToSent)
        formData.append('_token', '{{ csrf_token() }}')
        senderObject.disabled = true
        senderObject.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
        if (confirm('Are you sure ?')) {
            $.ajax({
                type: "post",
                url: `customer/file/${btoa(customerCode.value)}`,
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    senderObject.innerHTML = `<i class="fas fa-pencil"></i>`
                    alertify.success(response.msg)
                    senderObject.disabled = false
                    document.getElementById('div-alert').innerHTML = ''
                    fixedFileNameContainer.value = response.FixedFileName
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
                    senderObject.innerHTML = `<i class="fas fa-pencil"></i>`
                    alertify.warning(xthrow);
                    senderObject.disabled = false
                }
            });
        }
    }

    function btnChangeNPWPFile(firstSenderObject) {
        if (customerNPWPFile.files.length === 0) {
            customerNPWPFile.focus()
            alertify.warning(`NPWP file is required`)
            return
        }
        changeFile('MCUS_NPWP_FILE', customerNPWPFile.files[0], firstSenderObject, customerNPWPFilePath)
    }

    function btnChangeNIBFile(firstSenderObject) {
        if (customerNIBFile.files.length === 0) {
            customerNIBFile.focus()
            alertify.warning(`NIB file is required`)
            return
        }
        changeFile('MCUS_NIB_FILE', customerNIBFile.files[0], firstSenderObject, customerNIBFilePath)
    }
</script>