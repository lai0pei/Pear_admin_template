@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')

    <body class="pear-container">
        <div class="layui-card">
            <div class="layui-card-body">
                <blockquote class="layui-elem-quote">
                    说明:<br>
                    1.添加管理组时。 请确保 添加管理权限。<br>
                    2.该管理组 有用户，请先删除用户 再删除管理组。
                </blockquote>
            </div>
        </div>

        <div class="layui-card">
            <div class="layui-card-body">
                <table id="group-table" lay-filter="group-table"></table>
            </div>
        </div>

        <script type="text/html" id="group-toolbar">
            <button class="pear-btn pear-btn-primary pear-btn-md" lay-event="add">
                <i class="layui-icon layui-icon-add-1"></i>
                新增
            </button>
            <button class="pear-btn pear-btn-danger pear-btn-md" lay-event="batchRemove">
                <i class="layui-icon layui-icon-delete"></i>
                删除
            </button>
        </script>

        <script type="text/html" id="group-bar">
            <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i
                    class="layui-icon layui-icon-edit"></i></button>
            <button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i
                    class="layui-icon layui-icon-delete"></i></button>
        </script>

    </body>
@endsection
@section('js')
    <script>
        layui.use(['table', 'form', 'jquery', 'common', 'popup'], function() {
            let table = layui.table;
            let form = layui.form;
            let $ = layui.jquery;
            let common = layui.common;
            let popup = layui.popup;

            let cols = [
                [{
                        type: 'checkbox'
                    },
                    {
                        title: '编号',
                        field: 'id',
                        align: 'center',
                        sort: true,

                    },
                    {
                        title: '组合名称',
                        field: 'role_name',
                        align: 'center',

                    },
                    {
                        title: '状态',
                        field: 'status',
                        align: 'center',
                        sort: true,
                        width: 150,
                        templet: function(d) {
                            let check = (d.status) ? 'checked=" "' : '';
                            if (d.id != 1) {
                                return '<input type="checkbox" name="status" id="' + d.id + '" value="' + d
                                    .status +
                                    '" lay-skin="switch" lay-text="启用|禁用" lay-filter="role_status" ' +
                                    check + '/>';
                            } else {
                                return '<input type="checkbox" disabled name="status" id="' + d.id +
                                    '" value="' + d.status +
                                    '" lay-skin="switch" lay-text="启用|禁用" lay-filter="role_status" ' +
                                    check + '/>';

                            }
                        }

                    },
                    {
                        title: '描述',
                        field: 'description',
                        align: 'center',
                    },
                    {
                        title: '操作',
                        toolbar: '#group-bar',
                        align: 'center',
                        width: 130,

                    }
                ]
            ];

            table.render({
                elem: '#group-table',
                url: "{{ $route['list'] }}",
                page: true,
                cols: cols,
                skin: 'row',
                even: true,
                toolbar: '#group-toolbar',
                defaultToolbar: [{
                    title: '刷新',
                    layEvent: 'refresh',
                    icon: 'layui-icon-refresh',
                }, 'filter', 'print', 'exports']
            });

            form.on('switch(role_status)', function(obj) {
                var data = {
                    "id": obj.elem.id,
                    "status": (obj.value == 1) ? 0 : 1
                };
                var posts = post("{{ $route['status'] }}", data);
                msg(posts);
                window.refresh();
            })

            table.on('tool(group-table)', function(obj) {
                if (obj.event === 'remove') {
                    window.remove(obj);
                } else if (obj.event === 'edit') {
                    window.edit(obj);
                }
            });

            table.on('toolbar(group-table)', function(obj) {
                if (obj.event === 'add') {
                    window.add();
                } else if (obj.event === 'refresh') {
                    window.refresh();
                } else if (obj.event === 'batchRemove') {
                    window.batchRemove(obj);
                }
            });

            form.on('submit(user-query)', function(data) {
                table.reload('group-table', {
                    where: {
                        searchParams: data.field,
                    }
                })
                return false;
            });


            window.add = function() {
                layer.open({
                    type: 2,
                    title: '新增',
                    shade: 0.1,
                    area: [common.isModile() ? '100%' : '500px', common.isModile() ? '100%' : '600px'],
                    maxmin: true,
                    shadeClose: true,
                    content: "{{ $route['add_view'] }}"
                });
            }

            window.edit = function(obj) {
                layer.open({
                    type: 2,
                    title: '修改',
                    shade: 0.1,
                    maxmin: true,
                    shadeClose: true,
                    area: [common.isModile() ? '100%' : '500px', common.isModile() ? '100%' : '600px'],
                    content: "{{ $route['update_view'] }}/?id=" + obj.data.id
                });
            }

            window.remove = function(obj) {
                layer.confirm('确定要删除该用户', {
                    icon: 3,
                    title: '提示'
                }, function() {
                    msg(post("{{ $route['delete'] }}", {
                        'id': obj.data.id
                    }));
                    window.refresh();
                });
            }

            window.batchRemove = function(obj) {

                var checkIds = common.checkField(obj, 'id');

                if (checkIds === "") {
                    layer.msg("未选中数据", {
                        icon: 3,
                        time: 1000
                    });
                    return false;
                }

                layer.confirm('确定要删除这些管理员', {
                    icon: 3,
                    title: '提示'
                }, function(index) {
                    msg(post("{{ $route['delete'] }}", {
                        'id': checkIds
                    }));
                    window.refresh();
                });
            }

            window.refresh = function(param) {
                table.reload('group-table');
            }
        })
    </script>
@endsection
