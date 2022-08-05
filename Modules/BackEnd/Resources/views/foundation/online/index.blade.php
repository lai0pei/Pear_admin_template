@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
    <body class="pear-container">
        <div class="layui-card">
            <div class="layui-card-body">
                <blockquote class="layui-elem-quote">
                    说明:<br>
                    1.登录过期时间为-{{config('session.lifetime')}}分钟. 超过此时间 系统会自动 登出。<br>
                    2.永久登录 - 登录时 选择 "记住登录" 的管理员。 登录不会过期。<br>
                    3.过期登录 - 系统超过 {{config('session.lifetime')}}分钟 会自动过期.<br>
                    4.建议清除 过期的管理员。 如 永久登录管理员 有可疑 建议强制下线。
                  </blockquote>
            </div>
        </div>

        <div class="layui-card">
            <div class="layui-card-body">
                <table id="user-table" lay-filter="user-table"></table>
            </div>
        </div>

        <script type="text/html" id="user-bar">
            <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i
                    class="layui-icon layui-icon-edit"></i></button>
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
                        title: '账号',
                        field: 'account',
                        align: 'center',

                    },
                    {
                        title: '昵称',
                        field: 'username',
                        align: 'center',

                    },
                    {
                        title: '是否在线',
                        field: 'is_expire',
                        align: 'center',
                        sort: true,
                        templet: function(d) {
                            return (d.is_expire == 0) ? '<span style="color:green">在线</span>' :
                                '<span style="color:red">已过期</span>';
                        }
                    },
                    {
                        title: '登录方式',
                        field: 'is_remeber',
                        align: 'center',
                        sort: true,
                        templet: function(d) {
                            return (d.is_remember == 1) ? '永久登录' :
                            '过期登录';
                        }
                    },
                    {
                        title: '在线时长',
                        field: 'up_time',
                        align: 'center',
                        templet: function(d) {
                            let time = (d.up_time).split(":");
                            let hr = time[0];
                            let min = time[1];
                            let sec = time[2];
                            return hr + "时" + min + "分" + sec + "秒";
                        }
                    },
                    {
                        title: '强制下线',
                        field: 'status',
                        align: 'center',
                        sort: true,
                        width: 150,
                        templet: function(d) {
                                return (d.is_expire == 0) ? '<input type="checkbox" name="status" id="' + d.id +
                            '" lay-skin="switch" lay-text="下线|下线" lay-filter="admin_status" />' :
                            '<input type="checkbox" name="status" id="' + d.id +
                            '" lay-skin="switch" lay-text="删除|删除" lay-filter="admin_delete" />';
                    }
                },
                {
                    title: '登录Ip',
                    field: 'last_ip',
                    align: 'center',
                },
                {
                    title: '操作',
                    toolbar: '#user-bar',
                    align: 'center',
                    width: 130,

                }
            ]
        ];

        table.render({
            elem: '#user-table',
            url: "{{ $route['list'] }}",
            page: true,
            cols: cols,
            method : 'post',
            skin: 'row',
            even: true,
            toolbar: '#user-toolbar',
            defaultToolbar: [{
                title: '刷新',
                layEvent: 'refresh',
                icon: 'layui-icon-refresh',
            }, 'filter', 'print', 'exports']
        });

        form.on('switch(admin_status)', function(obj) {

            layer.confirm('确定要下线吗?', {
                icon: 3,
                title: '提示'
            }, function() {
                msg(post("{{ $route['status'] }}", {
                    "id": obj.elem.id,
                }));
                window.refresh();
            });

        })

        form.on('switch(admin_delete)', function(obj) {

            msg(post("{{ $route['status'] }}", {
                    "id": obj.elem.id,
                }));
                window.refresh();

        })

        table.on('tool(user-table)', function(obj) {
            if (obj.event === 'edit') {
                window.edit(obj);
            }
        });

        table.on('toolbar(user-table)', function(obj) {
            if (obj.event === 'refresh') {
                window.refresh();
            }
        });

        window.refresh = function(param) {
            table.reload('user-table');
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
        })
    </script>
@endsection
