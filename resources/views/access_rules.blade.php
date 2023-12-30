<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Access Rules</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="col-md-12 order-md-1">
            <div class="row">
                <div class="col-md-12 mb-1">
                    <div class="input-group input-group-sm">
                        <label class="input-group-text">User Group</label>
                        <select class="form-select" id="cmbgroup" required>
                            <option value="_">Choose...</option>
                            @foreach($RSRoles as $r)
                            <option value="{{ $r->name }}">{{ $r->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-1 text-center">
                    <i class="fas fa-universal-access fa-spin fa-9x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="table-responsive" id="divroles">
            <div id="setting-tree"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-1">
    </div>
    <div class="col-md-6 mb-1">
        <button id="btnSave" title="Save changes" class="btn btn-primary btn-block" type="submit" onclick="btnSaveOnClick(this)"><i class="fas fa-save"></i></button>
    </div>
</div>

<script>
    var tangkai = [];
    var lgroupid = [];
    var lmenuid = [];
    var lmenudefault = [];
    var settingTree = $('#setting-tree').tree({
        uiLibrary: 'bootstrap5',
        iconsLibrary: 'fontawesome',
        imageCssClassField: 'faCssClass',
        dataSource: '/api/setting/tree',
        primaryKey: 'id',
        checkboxes: true,
        cascadeCheck: false
    });
    $("#divroles").css('height', $(window).height() * 73 / 100);
    $('#cmbgroup').change(function() {
        const a = $(this).val();
        settingTree.uncheckAll()
        for (let i = 1; i < lgroupid.length; i++) {
            if (lgroupid[i] == a) {
                settingTree.check(settingTree.getNodeById(lmenuid[i]))
            }
        }
        settingTree.expandAll()
    });

    function btnSaveOnClick(pthis) {
        let nodesId = settingTree.getCheckedNodes()
        let AllNode = []
        let FinalNodes = []

        nodesId.forEach((item, index) => {
            if (item.length > 1) {
                let CurrentIdLength = item.length
                AllNode.push(item)
                while (CurrentIdLength > 1) {
                    let _node = item.substr(0, item.length - 1)
                    AllNode.push(_node)
                    CurrentIdLength--;
                }
            } else {
                AllNode.push(item)
            }
        })
        FinalNodes = [...new Set(AllNode)]
        let nodes = []
        let grpid = $('#cmbgroup').val()
        let s2 = ''
        if (grpid == '_') {
            alertify.message('nothing to be processed')
            return
        }

        pthis.disabled = true
        $.ajax({
            type: "post",
            url: "/api/setting/tree/roles",
            dataType: "json",
            data: {
                groupID: grpid,
                menuID: FinalNodes
            },
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": `Bearer ${sessionStorage.getItem('tokenGue')}`
            },
            success: function(response) {
                pthis.disabled = false
                alert('saved successfully')
                getAllAM()
            },
            error: function(xhr, ajaxOptions, throwError) {
                alertify.error(throwError);
                pthis.disabled = false
            }
        });
    }

    function insertTangkai(punik) {
        if (!tangkai.includes(punik)) {
            tangkai.push('' + punik + '');
        }
    }
    getAllAM();

    function getAllAM() {
        jQuery.ajax({
            type: "GET",
            url: "/api/setting/tree/roles",
            dataType: "json",
            success: function(response) {
                lgroupid.length = 0;
                lmenuid.length = 0;
                for (let i = 0; i < response.length; i++) {
                    lgroupid.push('' + response[i].role_name + '');
                    lmenuid.push('' + response[i].menu_code + '');
                }
            },
            error: function(xhr, ajaxOptions, throwError) {
                alertify.error(throwError);
            }
        })
    }


    $("#vacc_btn_showmod").click(function(e) {
        e.preventDefault();
        $("#VACC_MOD").modal('show');
    });
    $("#VACC_MOD").on('shown.bs.modal', function() {
        $("#vacc_txt_id").focus();
    });
</script>