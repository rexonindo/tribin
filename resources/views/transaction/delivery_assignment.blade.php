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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Quotation : <span id="labelQuotationInModal"></span></h1>
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
                                            <div class="col-md-6 mb-1">
                                                <div class="input-group input-group-sm mb-1">
                                                    <span class="input-group-text">Driver</span>
                                                    <select class="form-select" id="driver">
                                                        @foreach($Drivers as $r)
                                                        <option value="{{ $r->nick_name }}">{{ $r->name }}</option>
                                                        @endforeach
                                                    </select>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" id="btnAction">Action</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" onclick="approveQuotation(this)"><i class="fas fa-check text-success"></i> Assign</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
                    TDLVORD_DELIVERED_BY: driver.value,
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
</script>