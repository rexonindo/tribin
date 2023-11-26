divDashboardContainer.innerHTML = `<div class="table-responsive" id="divApprovalReportContainer">
<table id="tblApprovalReport" class="table table-striped table-sm table-hover">
    <thead>
        <tr>
            <th class="align-middle text-center" rowspan="2">Business</th>
            <th class="align-middle text-center" colspan="4">Approval</th>
        </tr>
        <tr>
            <th class="text-center">Quotation</th>
            <th class="text-center">Purchase Request</th>
            <th class="text-center">Purchase Order</th>
            <th class="text-center">SPK</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <tr><td colspan="6">Please wait</td></tr>
    </tbody>
</table>
</div>`

tbody = tblApprovalReport.getElementsByTagName('tbody')[0]
tbody.innerHTML = `<tr><td colspan="5" class="text-center">Please wait</td></tr>`
$.ajax({
    type: "GET",
    url: "approval/notifications/top-user",
    dataType: "JSON",
    success: function (response) {
        let myContainer = document.getElementById("divApprovalReportContainer");
        let myfrag = document.createDocumentFragment();
        let cln = tblApprovalReport.cloneNode(true);
        myfrag.appendChild(cln);
        let myTable = myfrag.getElementById("tblApprovalReport");
        let myTableBody = myTable.getElementsByTagName("tbody")[0];
        myTableBody.innerHTML = ''
        response.data.forEach((arrayItem) => {
            newrow = myTableBody.insertRow(-1)
            newcell = newrow.insertCell(-1)
            newcell.innerHTML = arrayItem['name']
            newcell = newrow.insertCell(-1)
            const _totalData = arrayItem['data'].length
            newcell.innerHTML = _totalData
            if (_totalData) {
                newcell.classList.add('text-info')
                newcell.style.cssText = "font-weight: bold; cursor: pointer"
                newcell.onclick = () => {
                    setCompanyGroupTopUser({ name: arrayItem['name'] })

                    ContentContainer.innerHTML = 'Please wait'
                    $.ajax({
                        type: "GET",
                        url: "/approval/form/quotation",
                        success: function (response) {
                            setInnerHTML(ContentContainer, response)
                        }
                    });
                }
            }

            newcell = newrow.insertCell(-1)
            let totalRows = response.PurchaseRequest.length
            for (let i = 0; i < totalRows; i++) {
                if (arrayItem['name'] === response.PurchaseRequest[i].name) {
                    const _totalData = response.PurchaseRequest[i].data.length
                    newcell.innerHTML = _totalData
                    if (_totalData) {
                        newcell.classList.add('text-info')
                        newcell.style.cssText = "font-weight: bold; cursor: pointer"
                        newcell.onclick = () => {
                            setCompanyGroupTopUser({ name: arrayItem['name'] })

                            ContentContainer.innerHTML = 'Please wait'
                            $.ajax({
                                type: "GET",
                                url: "/approval/form/purchase-request",
                                success: function (response) {
                                    setInnerHTML(ContentContainer, response)
                                }
                            });
                        }
                    }
                }
            }

            newcell = newrow.insertCell(-1)
            totalRows = response.PurchaseOrder.length
            for (let i = 0; i < totalRows; i++) {
                if (arrayItem['name'] === response.PurchaseOrder[i].name) {
                    const _totalData = response.PurchaseOrder[i].data.length
                    newcell.innerHTML = _totalData
                    if (_totalData) {
                        newcell.classList.add('text-info')
                        newcell.style.cssText = "font-weight: bold; cursor: pointer"
                        newcell.onclick = () => {
                            setCompanyGroupTopUser({ name: arrayItem['name'] })

                            ContentContainer.innerHTML = 'Please wait'
                            $.ajax({
                                type: "GET",
                                url: "/approval/form/purchase-order",
                                success: function (response) {
                                    setInnerHTML(ContentContainer, response)
                                }
                            });
                        }
                    }
                }
            }

            newcell = newrow.insertCell(-1)
            totalRows = response.SPKData.length
            for (let i = 0; i < totalRows; i++) {
                if (arrayItem['name'] === response.SPKData[i].name) {
                    const _totalData = response.SPKData[i].data.length
                    newcell.innerHTML = _totalData
                    if (_totalData) {
                        newcell.classList.add('text-info')
                        newcell.style.cssText = "font-weight: bold; cursor: pointer"
                        newcell.onclick = () => {
                            setCompanyGroupTopUser({ name: arrayItem['name'] })

                            ContentContainer.innerHTML = 'Please wait'
                            $.ajax({
                                type: "GET",
                                url: "/approval/form/spk",
                                success: function (response) {
                                    setInnerHTML(ContentContainer, response)
                                }
                            });
                        }
                    }
                }
            }
        })
        myContainer.innerHTML = ''
        myContainer.appendChild(myfrag)
    },
    error: function (xhr, xopt, xthrow) {
        tbody.innerHTML = `<tr><td colspan="6">${xthrow}</td></tr>`
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
    }
});

function setCompanyGroupTopUser(data) {
    const ttlrows = companyTabel.rows.length
    let id = ''
    let iFounded = 0
    for (let i = 1; i < ttlrows; i++) {
        if (data.name === companyTabel.rows[i].cells[1].innerText.trim()) {
            id = companyTabel.rows[i].cells[0].innerText.trim()
            iFounded = i
            companyTabel.rows[i].classList.add('table-info')
            companyTabel.rows[i].title = 'selected'
            break
        }
    }

    for (let i = 1; i < ttlrows; i++) {
        if (iFounded !== i) {
            companyTabel.rows[i].classList.remove('table-info')
            companyTabel.rows[i].title = 'not selected'
        }
    }

    labelCompany.innerText = data.name
    Cookies.set('CGID', id, {
        expires: 365
    });
    Cookies.set('CGNM', data.name, {
        expires: 365
    });
}