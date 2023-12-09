<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Driver Assignment</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="coa-form">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3" id="approvalContainer">

        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delivery Order : <span id="labelQuotationInModal"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col mb-1" id="div-alert">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab">Item</button>
                                    <button class="nav-link" id="nav-cost-tab" data-bs-toggle="tab" data-bs-target="#nav-cost" type="button" role="tab">Costs</button>
                                    <button class="nav-link" id="nav-map-tab" data-bs-toggle="tab" data-bs-target="#nav-map" type="button" role="tab">Map</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row">
                                            <div class="col-md-6 mb-1">
                                                <label for="quotationCustomer" class="form-label">Customer Name</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <input type="text" id="quotationCustomer" class="form-control" maxlength="50" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <label for="quotationCustomer" class="form-label">Address Name</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <input type="text" id="quotationAddressName" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <label for="quotationCustomer" class="form-label">Address Description</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <textarea id="quotationAddressDescription" class="form-control" disabled>
                                                    </textarea>
                                                </div>
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
                                                                <th class="text-center">Qty</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <input type="hidden" id="branch" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-cost" role="tabpanel" aria-labelledby="nav-cost-tab" tabindex="1">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row">
                                            <div class="col mb-1" id="div-alert-cost">
                                            </div>
                                        </div>
                                        <fieldset class="border rounded-3 p-2">
                                            <legend class="float-none w-auto px-3">Orang</legend>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">PIC As</span>
                                                        <select class="form-select" id="PICAs" onchange="PICAsOnChange(event)">
                                                            <option value="-">-</option>
                                                            <option value="DRIVER">DRIVER</option>
                                                            <option value="MECHANIC">MECHANIC</option>
                                                            <option value="OPERATOR">OPERATOR</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">PIC Name</span>
                                                        <select class="form-select" id="PICName">
                                                            @foreach($PICs as $r)
                                                            <option value="{{ $r->nick_name }}">{{ $r->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Tugas</span>
                                                        <input type="text" id="tugas" class="form-control orderInputItem" maxlength="70">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border rounded-3 p-2">
                                            <legend class="float-none w-auto px-3">Kendaraan</legend>
                                            <div class="row">
                                                <div class="col-md-3 mb-1">
                                                    <label for="KM" class="form-label">KM</label>
                                                    <input type="number" id="KM" class="form-control form-control-sm orderInputItem">
                                                </div>
                                                <div class="col-md-3 mb-1">
                                                    <label for="jenisKendaraan" class="form-label">Jenis</label>
                                                    <input type="text" id="jenisKendaraan" class="form-control form-control-sm orderInputItem" maxlength="35">
                                                </div>
                                                <div class="col-md-3 mb-1">
                                                    <label for="nomorPolisi" class="form-label">Nomor Polisi</label>
                                                    <input type="text" id="nomorPolisi" class="form-control form-control-sm orderInputItem" maxlength="15">
                                                </div>
                                                <div class="col-md-3 mb-1">
                                                    <label for="Wheels" class="form-label">Jumlah Roda</label>
                                                    <select class="form-select form-select-sm" id="Wheels">
                                                        <option value="4">4</option>
                                                        <option value="6">6</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-1">
                                                    <label class="form-label">Solar Supplier</label>
                                                    <select class="form-select form-select-sm" id="Supplier">
                                                        <option value="SPBU">SPBU</option>
                                                        <option value="JAT">JAT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-1">
                                                    <label class="form-label">Liters (Existing)</label>
                                                    <input type="number" id="litersExisting" class="form-control form-control-sm orderInputItem">
                                                </div>
                                                <div class="col-md-4 mb-1">
                                                    <label class="form-label">Liters</label>
                                                    <input type="number" id="liters" class="form-control form-control-sm orderInputItem">
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="border rounded-3 p-2">
                                            <legend class="float-none w-auto px-3">Biaya</legend>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Makan</span>
                                                        <input type="number" id="uangMakan" class="form-control orderInputItem">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Mandah</span>
                                                        <input type="number" id="uangMandah" class="form-control orderInputItem">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Pengawalan</span>
                                                        <input type="number" id="uangPengawalan" class="form-control orderInputItem">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Penginapan</span>
                                                        <input type="number" id="uangPenginapan" class="form-control orderInputItem">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Lain<sup>2</sup></span>
                                                        <input type="number" id="uangLain" class="form-control orderInputItem">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border rounded-3 p-2 mb-2">
                                            <legend class="float-none w-auto px-3">Waktu</legend>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <label for="tanggalBerangkat" class="form-label">Berangkat</label>
                                                    <input type="text" id="tanggalBerangkat" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <label for="tanggalKembali" class="form-label">Kembali</label>
                                                    <input type="text" id="tanggalKembali" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="row">
                                            <div class="col text-center mb-1">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-secondary" id="btnSaveLineSale" onclick="btnSaveLineSaleOnclick(this)">Save line</button>
                                                    <button type="button" class="btn btn-outline-secondary" id="btnRemoveLineSale" onclick="btnRemoveLineSaleOnclick(this)">Remove line</button>
                                                    <button type="button" class="btn btn-outline-secondary" id="btnUpdateLineSale" onclick="btnUpdateLineOnclick(this)">Update line</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <div class="table-responsive" id="costTableContainer">
                                                    <table id="costTable" class="table table-sm table-hover table-bordered caption-top">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th class="d-none">idLine</th>
                                                                <th class="d-none">PIC Id</th>
                                                                <th class="text-center"></th>
                                                                <th>PIC As</th>
                                                                <th>PIC Name</th>
                                                                <th>KM</th>
                                                                <th>Wheels</th>
                                                                <th style="white-space: nowrap;">Uang Jalan</th>
                                                                <th style="white-space: nowrap;">Solar Supplier</th>
                                                                <th style="white-space: nowrap;">Liters (Existing)</th>
                                                                <th>Liters</th>
                                                                <th style="white-space: nowrap;">Uang Solar</th>
                                                                <th style="white-space: nowrap;">Uang Makan</th>
                                                                <th style="white-space: nowrap;">Uang Mandah</th>
                                                                <th style="white-space: nowrap;">Penginapan</th>
                                                                <th style="white-space: nowrap;">Pengawalan</th>
                                                                <th style="white-space: nowrap;">Biaya Lain<sup>2</sup></th>
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
                                <div class="tab-pane fade" id="nav-map" role="tabpanel" tabindex="2">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <iframe id="frame1" height="256" frameborder="0" width="100%"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="selectedRowAtOrderTable">
<script>
    $("#tanggalBerangkat").datetimepicker({
        format: 'yyyy-mm-dd HH:MM:00',
        autoclose: true,
        uiLibrary: 'bootstrap5',
        footer: true
    })
    $("#tanggalKembali").datetimepicker({
        format: 'yyyy-mm-dd HH:MM:00',
        autoclose: true,
        uiLibrary: 'bootstrap5',
        footer: true
    })

    function PICAsOnChange(e) {
        if (e.target.value !== '-') {
            PICName.focus()
        }
    }

    function btnSaveLineSaleOnclick(p) {
        if (PICAs.value === '-') {
            alertify.message('PIC As is required')
            return
        }
        p.disabled = true
        const data = {
            CSPK_REFF_DOC: labelQuotationInModal.innerText,
            CSPK_PIC_AS: PICAs.value,
            CSPK_PIC_NAME: PICName.value,
            CSPK_KM: KM.value,
            CSPK_WHEELS: Wheels.value,
            CSPK_SUPPLIER: Supplier.value,
            CSPK_LITER: liters.value,
            CSPK_LITER_EXISTING: litersExisting.value,
            CSPK_UANG_MAKAN: uangMakan.value,
            CSPK_UANG_MANDAH: uangMandah.value,
            CSPK_UANG_PENGINAPAN: uangPenginapan.value,
            CSPK_UANG_PENGAWALAN: uangPengawalan.value,
            CSPK_UANG_LAIN2: uangLain.value,
            CSPK_LEAVEDT: tanggalBerangkat.value,
            CSPK_BACKDT: tanggalKembali.value,
            CSPK_VEHICLE_TYPE: jenisKendaraan.value,
            CSPK_JOBDESK: tugas.value,
            CSPK_VEHICLE_REGNUM: nomorPolisi.value,
            _token: '{{ csrf_token() }}',
        }
        const div_alert = document.getElementById('div-alert-cost')
        div_alert.innerHTML = `<div class="alert alert-info alert-dismissible fade show" role="alert">
                    Please wait
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`
        $.ajax({
            type: "POST",
            url: "SPK",
            data: data,
            dataType: "json",
            success: function(response) {
                PICAs.value = '-'
                tribinClearTextBoxByClassName('orderInputItem')
                p.disabled = false
                div_alert.innerHTML = `<div class="alert alert-info alert-dismissible fade show" role="alert">
                        Done
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`
                loadQuotationDetail({
                    doc: labelQuotationInModal.innerText,
                    branch: branch.value
                })
            },
            error: function(xhr, xopt, xthrow) {
                p.disabled = false
                const respon = Object.keys(xhr.responseJSON)

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

    function loadApprovalList() {
        approvalContainer.innerHTML = 'Please wait'
        $.ajax({
            type: "GET",
            url: "/assignment-driver/data/delivery",
            dataType: "json",
            success: function(response) {
                let innerHTML = ''
                approvalContainer.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    const col = document.createElement('div')
                    col.classList.add('col')
                    const elCard = document.createElement('div')
                    elCard.classList.add(...['card', 'shadow-sm'])
                    elCard.innerHTML = `<svg class="bd-placeholder-img card-img-top" width="100%" height="125" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Customer</title>
                    <rect width="100%" height="100%" fill="#188273" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">${arrayItem['MCUS_CUSNM']}</text>
                    </svg>`
                    const elCardBody = document.createElement('div')
                    elCardBody.classList.add('card-body')
                    const elCardBodyText = document.createElement('p')
                    elCardBodyText.classList.add('card-text')
                    elCardBodyText.innerHTML = '<b>' + arrayItem['TDLVORD_DLVCD'] + '</b>'

                    const elFlex = document.createElement('div')
                    elFlex.classList.add(...['d-flex', 'justify-content-between', 'align-items-center'])

                    const elButtonGrup = document.createElement('div')
                    elButtonGrup.classList.add(...['btn-group', 'btn-group-sm'])

                    const elButtonGrup2 = document.createElement('div')
                    elButtonGrup2.classList.add(...['btn-group', 'btn-group-sm'])

                    const elButton2 = document.createElement('button')
                    elButton2.classList.add(...['btn', 'btn-outline-primary'])
                    elButton2.innerHTML = 'Assign a driver'
                    elButton2.onclick = () => {
                        event.preventDefault()
                        quotationCustomer.value = arrayItem['MCUS_CUSNM']

                        labelQuotationInModal.innerHTML = arrayItem['TDLVORD_DLVCD']
                        branch.value = arrayItem['TDLVORD_BRANCH']
                        const myModal = new bootstrap.Modal(document.getElementById('quotationModal'), {})
                        myModal.show()
                        loadQuotationDetail({
                            doc: arrayItem['TDLVORD_DLVCD'],
                            branch: arrayItem['TDLVORD_BRANCH']
                        })
                    }

                    const elSmalltext = document.createElement('small')
                    elSmalltext.classList.add('text-body-secondary')
                    elSmalltext.innerText = moment(arrayItem['created_at']).startOf('hour').fromNow()

                    // combine                    
                    elButtonGrup.appendChild(elButton2)
                    elFlex.appendChild(elButtonGrup)
                    elFlex.appendChild(elSmalltext)
                    elCardBody.appendChild(elCardBodyText)
                    elCardBody.appendChild(elFlex)
                    elCard.appendChild(elCardBody)
                    col.appendChild(elCard)
                    approvalContainer.appendChild(col)
                })
            },
            error: function(xhr, xopt, xthrow) {
                approvalContainer.innerHTML = xthrow
            }
        });
    }
    loadApprovalList()

    function approveQuotation(pthis) {
        if (confirm('Are you sure ?')) {
            btnAction.disabled = true
            $.ajax({
                type: "PUT",
                url: `assignment-driver/form/delivery/${btoa(labelQuotationInModal.innerText)}`,
                data: {
                    _token: '{{ csrf_token() }}',
                    TDLVORD_BRANCH: branch.value,
                    TDLVORD_JALAN_COST: quotationUangJalan.value,
                    TDLVORD_VEHICLE_REGNUM: quotationVehicleRegistrationNumber.value,
                },
                dataType: "json",
                success: function(response) {
                    $("#quotationModal").modal('hide')
                    btnAction.disabled = false
                    loadApprovalList()
                    showNotificationToApprove()
                },
                error: function(xhr, xopt, xthrow) {
                    btnAction.disabled = false
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

    function loadQuotationDetail(data) {
        quotationAddressName.value = 'Please wait'
        quotationAddressDescription.value = 'Please wait'
        costTable.getElementsByTagName('tbody')[0].innerHTML = `<tr><td class="text-center" colspan="16">Please wait</td></tr>`
        $.ajax({
            type: "GET",
            url: `delivery/document/${btoa(data.doc)}`,
            data: {
                TDLVORDDETA_BRANCH: data.branch
            },
            dataType: "json",
            success: function(response) {
                quotationAddressName.value = response.SalesOrder[0].TSLO_ADDRESS_NAME
                quotationAddressDescription.value = response.SalesOrder[0].TSLO_ADDRESS_DESCRIPTION
                frame1.src = response.SalesOrder[0].TSLO_MAP_URL
                let myContainer = document.getElementById("quotationTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = quotationTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("quotationTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                let grandTotal = 0
                response.data.forEach((arrayItem) => {
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
                    newcell.innerHTML = arrayItem['TDLVORDDETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TDLVORDDETA_ITMQT']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)

                myContainer = document.getElementById("costTableContainer");
                myfrag = document.createDocumentFragment();
                cln = costTable.cloneNode(true);
                myfrag.appendChild(cln);
                myTable = myfrag.getElementById("costTable");
                myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''

                response.SPK.forEach((arrayItem) => {
                    let elemDropDownContainer = document.createElement('div')
                    let elem = document.createElement('button')
                    let elemPrint = document.createElement('a')
                    let elemSubmit = document.createElement('a')
                    let elemUl = document.createElement('ul')
                    let elemLi = document.createElement('li')
                    elemDropDownContainer.classList.add('dropdown')
                    elem.classList.add('btn', 'btn-sm', 'btn-info', 'btn-icon', 'dropdown-toggle')
                    elem.innerHTML = 'Action'
                    elem.setAttribute('data-bs-toggle', 'dropdown')

                    elemUl.classList.add('dropdown-menu')

                    elemPrint.classList.add('dropdown-item')
                    elemPrint.innerHTML = 'Print'
                    elemPrint.setAttribute('href', '#')
                    elemPrint.onclick = function() {
                        window.open(`PDF/SPK/${btoa(arrayItem['id'])}`, '_blank');
                    }
                    elemSubmit.classList.add('dropdown-item')

                    elemSubmit.setAttribute('href', '#')
                    elemSubmit.onclick = function() {
                        if (confirm('Are you sure ?')) {
                            const div_alert = document.getElementById('div-alert-cost')
                            elemSubmit.innerHTML = 'Please wait'
                            elemSubmit.classList.add('disabled')
                            $.ajax({
                                type: "PUT",
                                url: `SPK/submit/${btoa(arrayItem['id'])}`,
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: "json",
                                success: function(response) {
                                    elemSubmit.innerHTML = 'Submitted'
                                    alertify.message(response.message)
                                },
                                error: function(xhr, xopt, xthrow) {
                                    elemSubmit.innerHTML = 'Submit'
                                    elemSubmit.classList.remove('disabled')
                                    const respon = Object.keys(xhr.responseJSON)
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
                    if (arrayItem['submitted_at']) {
                        elemSubmit.innerHTML = 'Submitted'
                        elemSubmit.classList.add('disabled')
                    } else {
                        elemSubmit.innerHTML = 'Submit'
                    }

                    elemLi.appendChild(elemSubmit)
                    elemLi.appendChild(elemPrint)
                    elemUl.appendChild(elemLi)

                    elemDropDownContainer.appendChild(elem)
                    elemDropDownContainer.appendChild(elemUl)

                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        if (['BUTTON', 'A'].includes(event.target.tagName)) {
                            return
                        }
                        const selrow = costTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                            selectedRowAtOrderTable.value = -1
                        } else {
                            const ttlrows = costTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                costTable.rows[i].classList.remove('table-info')
                                costTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                            selectedRowAtOrderTable.value = event.target.parentElement.rowIndex
                            PICAs.value = arrayItem['CSPK_PIC_AS']
                            PICName.value = arrayItem['CSPK_PIC_NAME']
                            KM.value = arrayItem['CSPK_KM']
                            Wheels.value = arrayItem['CSPK_WHEELS']
                            Supplier.value = arrayItem['CSPK_SUPPLIER']
                            liters.value = arrayItem['CSPK_LITER']
                            litersExisting.value = arrayItem['CSPK_LITER_EXISTING']
                            uangMakan.value = arrayItem['CSPK_UANG_MAKAN']
                            uangMandah.value = arrayItem['CSPK_UANG_MANDAH']
                            uangPengawalan.value = arrayItem['CSPK_UANG_PENGAWALAN']
                            uangPenginapan.value = arrayItem['CSPK_UANG_PENGINAPAN']
                            uangLain.value = arrayItem['CSPK_UANG_LAIN2']
                            tanggalBerangkat.value = arrayItem['CSPK_LEAVEDT']
                            tanggalKembali.value = arrayItem['CSPK_BACKDT']
                            jenisKendaraan.value = arrayItem['CSPK_VEHICLE_TYPE']
                            nomorPolisi.value = arrayItem['CSPK_VEHICLE_REGNUM']
                            tugas.value = arrayItem['CSPK_JOBDESK']
                        }
                    }
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['CSPK_PIC_NAME']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-center')
                    newcell.appendChild(elemDropDownContainer)
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['CSPK_PIC_AS']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['CSPK_PIC_NAME']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['CSPK_KM']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['CSPK_WHEELS']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['CSPK_UANG_JALAN']).format(',')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['CSPK_SUPPLIER']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['CSPK_LITER_EXISTING']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['CSPK_LITER']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['CSPK_UANG_SOLAR']).format(',')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['CSPK_UANG_MAKAN']).format(',')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['CSPK_UANG_MANDAH']).format(',')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['CSPK_UANG_PENGINAPAN']).format(',')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['CSPK_UANG_PENGAWALAN']).format(',')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['CSPK_UANG_LAIN2']).format(',')

                    tanggalBerangkat.value = arrayItem['CSPK_LEAVEDT']
                    tanggalKembali.value = arrayItem['CSPK_BACKDT']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
                quotationAddressName.value = ''
                quotationAddressDescription.value = ''
            }
        });
    }

    function btnUpdateLineOnclick(pthis) {
        const data = {
            CSPK_REFF_DOC: labelQuotationInModal.innerText,
            CSPK_PIC_AS: PICAs.value,
            CSPK_PIC_NAME: PICName.value,
            CSPK_KM: KM.value,
            CSPK_WHEELS: Wheels.value,
            CSPK_SUPPLIER: Supplier.value,
            CSPK_LITER: liters.value,
            CSPK_LITER_EXISTING: litersExisting.value,
            CSPK_UANG_MAKAN: uangMakan.value,
            CSPK_UANG_MANDAH: uangMandah.value,
            CSPK_UANG_PENGINAPAN: uangPenginapan.value,
            CSPK_UANG_PENGAWALAN: uangPengawalan.value,
            CSPK_UANG_LAIN2: uangLain.value,
            CSPK_LEAVEDT: tanggalBerangkat.value,
            CSPK_BACKDT: tanggalKembali.value,
            CSPK_VEHICLE_TYPE: jenisKendaraan.value,
            CSPK_VEHICLE_REGNUM: nomorPolisi.value,
            CSPK_JOBDESK: tugas.value,
            _token: '{{ csrf_token() }}'
        }
        const idRow = costTable.rows[selectedRowAtOrderTable.value].cells[0].innerText
        if (confirm('Are you sure ?')) {
            const div_alert = document.getElementById('div-alert-cost')
            pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
            pthis.disabled = true
            $.ajax({
                type: "PUT",
                url: `SPK/${btoa(idRow)}`,
                data: data,
                dataType: "json",
                success: function(response) {
                    pthis.disabled = false
                    pthis.innerHTML = `Update line`
                    alertify.success(response.msg)
                    pthis.disabled = false
                    div_alert.innerHTML = ''
                    loadQuotationDetail({
                        doc: labelQuotationInModal.innerText,
                        branch: branch.value
                    })
                },
                error: function(xhr, xopt, xthrow) {
                    const respon = Object.keys(xhr.responseJSON)
                    let msg = ''
                    for (const item of respon) {
                        msg += `<p>${xhr.responseJSON[item]}</p>`
                    }
                    div_alert.innerHTML = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            ${msg}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                    pthis.innerHTML = `Update line`
                    alertify.warning(xthrow);
                    pthis.disabled = false
                }
            });
        }
    }

    function btnRemoveLineSaleOnclick(pthis) {
        const idRow = costTable.rows[selectedRowAtOrderTable.value].cells[0].innerText
        if (confirm('Are you sure ?')) {
            const div_alert = document.getElementById('div-alert-cost')
            pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
            pthis.disabled = true
            $.ajax({
                type: "DELETE",
                url: `SPK/${btoa(idRow)}`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function(response) {
                    pthis.disabled = false
                    pthis.innerHTML = `Remove line`
                    alertify.success(response.message)
                    pthis.disabled = false
                    div_alert.innerHTML = ''
                    loadQuotationDetail({
                        doc: labelQuotationInModal.innerText,
                        branch: branch.value
                    })
                },
                error: function(xhr, xopt, xthrow) {
                    const respon = Object.keys(xhr.responseJSON)
                    let msg = ''
                    for (const item of respon) {
                        msg += `<p>${xhr.responseJSON[item]}</p>`
                    }
                    div_alert.innerHTML = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            ${msg}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                    pthis.innerHTML = `Remove line`
                    alertify.warning(xthrow);
                    pthis.disabled = false
                }
            });
        }
    }
</script>