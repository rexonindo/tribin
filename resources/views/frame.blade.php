<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title>Home · JOS</title>

    <link rel="icon" href="{{ url('assets/fiximgs/favicon.png') }}">
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/alertify/css/alertify.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/alertify/css/themes/semantic.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/fontaw/css/all.css') }}" rel="stylesheet">
    <link href="{{ url('assets/gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/DataTables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ url('assets/jquery/jquery.min.js') }} "></script>
    <script src="{{ url('assets/alertify/alertify.min.js') }} "></script>
    <script src="{{ url('assets/gijgo/js/gijgo.min.js') }} "></script>
    <script src="{{ url('assets/js/tribin.js') }} "></script>
    <script src="{{ url('assets/js/moment.min.js') }} "></script>
    <script src="{{ url('assets/js/FileSaver.js') }} "></script>
    <script src="{{ url('assets/numeral/numeral.min.js') }} "></script>
    <script src="{{ url('assets/DataTables/datatables.min.js') }} "></script>
    <script type="text/javascript" src="{{ url('assets/js/js.cookie.min.js') }}"></script>
    <!-- Favicons -->
    <meta name="theme-color" content="#712cf9">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        thead tr.first th,
        thead tr.first td {
            position: sticky;
            top: 0;
        }

        /* sidebar custom */
    </style>

    <!-- Custom styles for this template -->
    <link href="{{ url('assets/bootstrap/ovrcss/dashboard.css') }}" rel="stylesheet">
</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>


    <header class="navbar bg-white sticky-top flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="{{ url ('home')}}">JAT Online System</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" id="myCollapse" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav w-100"></div>
        <div class="navbar-nav">
            <div class="nav-item dropdown text-nowrap">
                <a class="nav-link dropdown-toggle col-md-3 col-lg-2 me-0 px-3 fs-6" href="#" role="button" data-bs-toggle="dropdown" onclick="showNotificationToApprove()">
                    <span data-feather="mail" class="align-text-bottom"></span>
                    <span class="badge text-bg-info" id="labelNotifAll"></span>
                </a>
                <ul id="ulHeadContainer" class="dropdown-menu position-absolute dropdown-menu-lg-end dropdown-menu-md-end">
                    <li id="liHeadQuotation">
                        <h6 class="dropdown-header">Quotation</h6>
                    </li>
                    <li id="liHeadPurchaseRequest">
                        <h6 class="dropdown-header">Purchase Request</h6>
                    </li>
                    <li id="liHeadPurchaseOrder">
                        <h6 class="dropdown-header">Purchase Order</h6>
                    </li>
                    <li id="liHeadSalesOrderDraft">
                        <h6 class="dropdown-header">Sales Order Draft</h6>
                    </li>
                    <li id="liHeadDelivery">
                        <h6 class="dropdown-header">Delivery</h6>
                    </li>
                    <li id="liHeadSPK">
                        <h6 class="dropdown-header">SPK</h6>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-nav">
            <div class="nav-item dropdown text-nowrap">
                <a class="nav-link dropdown-toggle col-md-3 col-lg-2 me-0 px-3 fs-6" href="#" role="button" data-bs-toggle="dropdown" title="Company">
                    <span class="align-text-bottom fas fa-building"></span>
                    <span class="badge bg-info" id="labelCompany">-</span>
                </a>
                <ul class="dropdown-menu position-absolute dropdown-menu-lg-end dropdown-menu-md-end">
                    <li><a class="dropdown-item" href="#" onclick="lishowCompanySelectionModal(event)">Select Company</a></li>
                    @if (Auth::user()->role === 'root')
                    <li><a class="dropdown-item" href="#" onclick="lishowCompanyAccessControlForm(event)">Company Access Control</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link col-md-3 col-lg-2 me-0 px-3 fs-6" href="#" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
                    <span class="align-text-bottom fas fa-user"></span> {{ ucfirst(substr(Auth::user()->name, 0 ,21))}}
                </a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse overflow-y-auto">
                <div class="position-sticky pt-2 sidebar-sticky ">
                    <div id="tree"></div>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="konten-div">
                @yield('konten')
            </main>
        </div>
    </div>

    <!-- Item Modal -->
    <div class="modal fade" id="companyModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Company Group</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive" id="companyTabelContainer">
                                    <table id="companyTabel" class="table table-sm table-striped table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="d-none">...</th>
                                                <th>Company Name</th>
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
                <div class="modal-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <button class="btn btn-primary btn-sm" onclick="frameSetCompany()">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasEndLabel">Your info</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col border-end">
                        <span class="fas fa-user" title="Your name"></span>
                        <strong class="ms-3">{{ substr(Auth::user()->name, 0 ,21)}}</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-1 border-end">
                        <span class="fas fa-id-badge" title="Role"></span>
                        <small class="ms-3">{{ $activeRoleDescription }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-1 border-end">
                        <span class="fas fa-city" title="Branch"></span>
                        <strong class="ms-2">{{ $BranchName }}</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a class="btn btn-danger btn-sm" href="{{route('actionlogout')}}" title="Exit from system" onclick="btnLogout_eClick(event)">
                            <span data-feather="log-out" class="align-text-bottom"></span> Sign out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('assets/feathericon/feather.min.js') }} "></script>
    <script src="{{ url('assets/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script src="{{ url('assets/js/inputmask.min.js') }} "></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js" integrity="sha384-gdQErvCNWvHQZj6XZM0dNsAoY4v+j5P1XDpNkcM3HJG1Yx04ecqIHk7+4VBOCHOG" crossorigin="anonymous"></script>
    @if (!in_array(Auth::user()->role, ['director','manager', 'general_manager']) )
    <script>
        function showNotificationToApprove() {
            $.ajax({
                type: "GET",
                url: "/approval/notifications",
                dataType: "json",
                success: function(response) {
                    // Quotations
                    const totalNotifQT = response.data.length
                    const totalNotifApprovedQT = response.dataApproved.length

                    // Purchase Request
                    const totalNotifQTPurchaseRequest = response.dataPurchaseRequest.length
                    const totalNotifApprovedQTPurchaseRequest = response.dataPurchaseRequestApproved.length

                    // Sales Order Draft
                    const totalNotifQTSalesOrderDraft = response.dataSalesOrderDraft.length

                    // Purchase Order
                    const totalNotifQTPurchaseOrder = response.dataPurchaseOrder.length

                    // Delivery Order
                    const totalNotifQTDeliveryNoDriver = response.dataDeliveryOrderNoDriver.length
                    const totalNotifQTDeliveryUndelivered = response.dataDeliveryOrderUndelivered.length

                    // SPK
                    const totalNotifQTUnApprovedSPK = response.dataUnApprovedSPK.length

                    const totalNotif = totalNotifQT + totalNotifApprovedQT + totalNotifQTPurchaseRequest + totalNotifApprovedQTPurchaseRequest + totalNotifQTSalesOrderDraft +
                        totalNotifQTPurchaseOrder + totalNotifQTDeliveryNoDriver + totalNotifQTDeliveryUndelivered +
                        totalNotifQTUnApprovedSPK
                    labelNotifAll.innerHTML = totalNotif === 0 ? '' : totalNotif

                    // Quotations Group
                    createLiItem('linotif1', 'labelNotifApprovalQuotation', 'Quotation Approval', totalNotifQT, liHeadQuotation, liApprovalOnclick)
                    createLiItem('linotif2', 'labelNotifApprovedQuotation', 'Quotation Recent Updates', totalNotifApprovedQT, liHeadQuotation, liApprovedQuotationOnclick)

                    // Purchase Request Group
                    createLiItem('linotif3', 'labelNotifApprovalPurchaseRequest', 'Purchase Request Approval', totalNotifQTPurchaseRequest, liHeadPurchaseRequest, liApprovalPurchaseRequestOnclick)
                    createLiItem('linotif4', 'labelNotifApprovedPurchaseRequest', 'Purchase Request Recent Updates', totalNotifApprovedQTPurchaseRequest, liHeadPurchaseRequest, liApprovedPurchaseRequestOnclick)

                    // Purchase Order Group
                    createLiItem('linotif5', 'labelNotifApprovalPurchaseOrder', 'Purchase Order Approval', totalNotifQTPurchaseOrder, liHeadPurchaseOrder, liApprovalPurchaseOrderOnclick)

                    // Sales Order Draft Group
                    createLiItem('linotif6', 'labelNotifApprovalSalesOrderDraft', 'Sales Order Draft Status', totalNotifQTSalesOrderDraft, liHeadSalesOrderDraft, liApprovalSalesOrderDraftOnclick)

                    // Delivery Group
                    createLiItem('linotif7', 'labelNotifDeliveryAssignment', 'Delivery Assignment', totalNotifQTDeliveryNoDriver, liHeadDelivery, liDeliveryAssignmentOnclick)
                    createLiItem('linotif8', 'labelNotifDeliveryOnGoing', 'On going', totalNotifQTDeliveryUndelivered, liHeadDelivery, liDeliveryOnGoingOnclick)
                    // SPK Group
                    createLiItem('linotif9', 'labelNotifUnApprovedSPK', 'SPK Approval', totalNotifQTUnApprovedSPK, liHeadSPK, liUnApprovedSPKOnclick)
                }
            });
        }

        showNotificationToApprove()
    </script>
    @endif

    <script>
        const mybsCollapse = new bootstrap.Collapse(sidebarMenu, {
            toggle: false
        })
        feather.replace()
        const ContentContainer = document.getElementById('konten-div')
        const mainTree = $('#tree').tree({
            uiLibrary: 'bootstrap5',
            iconsLibrary: 'fontawesome',
            imageCssClassField: 'faCssClass',
            dataSource: '/menu',
            primaryKey: 'id',
            icons: {
                expand: `<span style="color: Tomato"><i class="fas fa-folder" /></span>`,
                collapse: `<span style="color: Tomato"><i class="fas fa-folder-open" /></span>`,
            }
        });
        let CGID = ''
        mainTree.on('select', function(e, node, id) {
            const SelectedData = mainTree.getDataById(id)

            if (SelectedData.appUrl) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: SelectedData.appUrl,
                    dataType: "text",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                        if (!myCollapse.classList.contains('collapsed')) {
                            mybsCollapse.toggle()
                        }

                    }
                });
            }
        })

        function btnLogout_eClick(e) {
            e.preventDefault()
            if (confirm('Log out ?')) {
                $.ajax({
                    type: "GET",
                    url: "/api/logout",
                    dataType: "json",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "Authorization": `Bearer ${sessionStorage.getItem('tokenGue')}`
                    },
                    success: function(response) {
                        sessionStorage.removeItem("tokenGue");
                        location.href = `{{route('actionlogout')}}`
                    },
                    error: function(xhr, xopt, xthrow) {
                        location.href = `{{route('actionlogout')}}`
                    }
                });
            }
        }

        function createLiItem(IDElement, IDElementChild, description, totalNotif, IDTop, callback) {
            let collectionsLi = ulHeadContainer.getElementsByTagName('li')
            let isFound = false
            for (let i of collectionsLi) {
                if (i.id === IDElement) {
                    isFound = true
                    break
                }
            }
            if (!isFound) {
                let elemLi = document.createElement('li')
                let elemA = document.createElement('a')
                let elemSpan = document.createElement('span')
                elemSpan.classList.add('badge', 'text-bg-info')
                elemSpan.innerText = totalNotif === 0 ? '' : totalNotif
                elemSpan.id = IDElementChild
                elemLi.id = IDElement
                elemA.innerText = description + ' '
                elemA.classList.add('dropdown-item')
                elemA.appendChild(elemSpan)
                elemA.onclick = callback
                elemA.href = '#'
                elemLi.append(elemA)
                IDTop.insertAdjacentElement('afterend', elemLi)
            } else {
                const elemNotif = document.getElementById(IDElementChild)
                elemNotif.innerText = totalNotif === 0 ? '' : totalNotif
            }
        }

        function liDeliveryConfirmOnClick() {
            alert('konfirmasi pengiriman')
        }

        function liApprovalOnclick(e) {
            e.preventDefault()
            if (labelNotifApprovalQuotation.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/approval/form/quotation",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }

        function liDeliveryAssignmentOnclick(e) {
            e.preventDefault()
            if (labelNotifDeliveryAssignment.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/assignment-driver/form/delivery",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }

        function liDeliveryOnGoingOnclick(e) {
            e.preventDefault()
            if (labelNotifDeliveryOnGoing.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/confirmation/form/delivery",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }

        function liUnApprovedSPKOnclick(e) {
            e.preventDefault()
            if (labelNotifUnApprovedSPK.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/approval/form/spk",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }

        function liApprovedQuotationOnclick(e) {
            e.preventDefault()
            if (labelNotifApprovedQuotation.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/approved/form/quotation",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }

        function lishowCompanySelectionModal() {
            const myModal = new bootstrap.Modal(document.getElementById('companyModal'), {})
            myModal.show()
        }

        function lishowCompanyAccessControlForm() {
            ContentContainer.innerHTML = 'Please wait'
            $.ajax({
                type: "GET",
                url: '/company/form',
                dataType: "text",
                success: function(response) {
                    setInnerHTML(ContentContainer, response)
                    if (!myCollapse.classList.contains('collapsed')) {
                        mybsCollapse.toggle()
                    }

                }
            });
        }

        showCompanyAcess()

        function showCompanyAcess() {
            companyTabel.getElementsByTagName('tbody')[0].innerHTML = '<tr><td colspan="2">Please wait</td></tr>'
            $.ajax({
                type: "get",
                url: `company/access/{{ base64_encode(Auth::user()->nick_name) }}`,
                dataType: "JSON",
                success: function(response) {
                    let myContainer = document.getElementById("companyTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = companyTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("companyTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newrow.onclick = (event) => {
                            const selrow = companyTabel.rows[event.target.parentElement.rowIndex]
                            if (selrow.title === 'selected') {
                                selrow.title = 'not selected'
                                selrow.classList.remove('table-info')
                            } else {
                                const ttlrows = companyTabel.rows.length
                                for (let i = 1; i < ttlrows; i++) {
                                    companyTabel.rows[i].classList.remove('table-info')
                                    companyTabel.rows[i].title = 'not selected'
                                }
                                selrow.title = 'selected'
                                selrow.classList.add('table-info')
                            }
                        }
                        newcell = newrow.insertCell(0)
                        newcell.classList.add('d-none')
                        newcell.innerHTML = arrayItem['connection']
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['name']

                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)

                    // pilih berdasarkan cookie
                    const ttlrows = companyTabel.rows.length
                    let nm = ''
                    for (let i = 1; i < ttlrows; i++) {
                        nm = companyTabel.rows[i].cells[1].innerText.trim()
                        if (nm === Cookies.get('CGNM')) {
                            companyTabel.rows[i].classList.add('table-info')
                            companyTabel.rows[i].title = 'selected'
                            labelCompany.innerText = nm
                            break
                        }
                    }
                }
            });
        }

        function frameSetCompany() {
            const ttlrows = companyTabel.rows.length
            let id = ''
            let companyName = ''
            let iFounded = 0
            for (let i = 1; i < ttlrows; i++) {
                if (companyTabel.rows[i].title === 'selected') {
                    id = companyTabel.rows[i].cells[0].innerText.trim()
                    companyName = companyTabel.rows[i].cells[1].innerText.trim()
                    iFounded = i
                    break
                }
            }
            if (iFounded === 0) {
                alertify.warning('Please select a company first')
                return
            }
            labelCompany.innerText = companyName
            Cookies.set('CGID', id, {
                expires: 365
            });
            Cookies.set('CGNM', companyName, {
                expires: 365
            });
            $('#companyModal').modal('hide')
            location.href = '/home'
        }

        function liApprovalPurchaseRequestOnclick(e) {
            e.preventDefault()
            if (labelNotifApprovalPurchaseRequest.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/approval/form/purchase-request",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }

        function liApprovedPurchaseRequestOnclick(e) {
            e.preventDefault()
            if (labelNotifApprovedPurchaseRequest.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/approved/form/purchase-request",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }

        function liApprovalSalesOrderDraftOnclick(e) {
            e.preventDefault()
            if (labelNotifApprovalSalesOrderDraft.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/approved/form/sales-order-draft",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }

        function liApprovalPurchaseOrderOnclick(e) {
            e.preventDefault()
            if (labelNotifApprovalPurchaseOrder.innerText.length > 0) {
                ContentContainer.innerHTML = 'Please wait'
                $.ajax({
                    type: "GET",
                    url: "/approval/form/purchase-order",
                    success: function(response) {
                        setInnerHTML(ContentContainer, response)
                    }
                });
            }
        }
    </script>
</body>

</html>