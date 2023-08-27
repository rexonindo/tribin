<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Branch Master</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
        </div>
    </div>
</div>
<form id="branch-form">
    <div class="row">
        <div class="col mb-1" id="div-alert">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Code</span>
                <input type="text" id="branchCode" class="form-control" placeholder="Branch Code" maxlength="3">
                <button class="btn btn-primary" type="button" onclick="btnShowBranchModal()"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col-md-6 mb-1">
            <div class="input-group input-group-sm mb-1">
                <span class="input-group-text">Name</span>
                <input type="text" id="branchName" class="form-control" placeholder="Branch Name" maxlength="50" onkeypress="branchNameOnKeypress(event)">
            </div>
        </div>
    </div>
    <input type="hidden" id="branchInputMode" value="0">
</form>
<!-- Modal -->
<div class="modal fade" id="branchModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Branch List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="branchSearchBy" class="form-select" onchange="branchSearch.focus()">
                                    <option value="0">Code</option>
                                    <option value="1">Name</option>
                                </select>
                                <input type="text" id="branchSearch" class="form-control" maxlength="50" onkeypress="branchSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="branchTabelContainer">
                                <table id="branchTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
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
        branchCode.value = ''
        branchCode.disabled = false
        branchCode.focus()
        tribinClearTextBox()
        branchInputMode.value = 0
    }

    function branchNameOnKeypress(e) {
        if (e.key === 'Enter') {
            btnSaveOnclick(btnSave)
        }
    }

    function btnSaveOnclick(pthis) {
        if (branchCode.value.trim().length <= 2) {
            branchCode.focus()
            alertify.warning(`Code is required`)
            return
        }
        if (branchName.value.trim().length <= 2) {
            branchName.focus()
            alertify.warning(`Name is required`)
            return
        }
        const data = {
            MBRANCH_CD: branchCode.value.trim(),
            MBRANCH_NM: branchName.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (branchInputMode.value === '0') {
            if (confirm(`Are you sure ?`)) {
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "post",
                    url: "branch",
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
                    MBRANCH_NM: branchName.value.trim(),
                    _token: '{{ csrf_token() }}',
                }
                pthis.innerHTML = `Please wait...`
                pthis.disabled = true
                $.ajax({
                    type: "put",
                    url: `branch/${btoa(branchCode.value)}`,
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

    function btnShowBranchModal() {
        const myModal = new bootstrap.Modal(document.getElementById('branchModal'), {})
        branchModal.addEventListener('shown.bs.modal', () => {
            branchSearch.focus()
        })
        myModal.show()
    }

    function branchSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: branchSearchBy.value,
                searchValue: e.target.value,
            }
            branchTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="2">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "branch",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("branchTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = branchTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("branchTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['MBRANCH_CD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#branchModal').modal('hide')
                            branchInputMode.value = 1
                            branchCode.value = arrayItem['MBRANCH_CD']
                            branchName.value = arrayItem['MBRANCH_NM']
                            branchCode.disabled = true
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MBRANCH_NM']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    branchTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="2">Please try again</td></tr>`
                }
            });
        }
    }
</script>