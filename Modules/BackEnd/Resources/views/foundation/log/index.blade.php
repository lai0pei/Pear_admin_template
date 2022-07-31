@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
<body class="pear-container">
<div class="layui-card">
    <div class="layui-card-body">
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <li class="layui-this">日志列表</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <table style="margin-top: 10px;" id="log-login-table" lay-filter="user-table"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="log-bar">
    <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="view"><i class="layui-icon layui-icon-edit"></i></button>
</script>
</body>

@endsection
@section('js')
<script>
    layui.use(['table','form','jquery','element'],function () {
        let table = layui.table;
        let form = layui.form;
        let element = layui.element;

        let cols = [
            [
                {
                    title: '行为', 
                    field: 'title', 
                    align:'center'
                },
                {
                    title: '模块', 
                    field: 'path', 
                    align:'center'
                },
                {
                    title: '浏览器', 
                    field: 'browser', 
                    align:'center',
                    width: 250,
                },
                {
                    title: '操作地址', 
                    field: 'ip',
                    align:'center'
                },
                {
                    title: '操作系统', 
                    field: 'os', 
                    align:'center'
                },
                {
                    title: '访问时间', 
                    field: 'created_at', 
                    align:'center'
                },
                {
                    title: '操作人', 
                    field: 'admin_name', 
                    align:'center'
                },
                {
                    title: '访问状态', 
                    field: 'success',
                    templet: function(d){
                        if(d.success == 1){
                            return  '<button class="pear-btn pear-btn-sm pear-btn-success">正常</button>';
                        }else{
                          return  '<button class="pear-btn pear-btn-sm pear-btn-danger">异常</button>';
                        }
                    }, 
                    align:'center', 
                    width:150
                },
                {
                    title: '操作',
                    toolbar: '#log-bar',
                    align: 'center',
                    width: 130,
                },

            ]
        ]

        table.render({
            elem: '#log-login-table',
            url: "{{$route['list']}}",
            page: true ,
            cols: cols ,
            skin: 'line',
            toolbar: false
        });

       
        table.on('tool(user-table)', function(obj) {
            if (obj.event === 'view') {
                layer.open({
                type: 2,
                title: '异常信息',
                maxmin: true,
                shadeClose: true,
                area: ['450px', '350px'],
                content: "{{$route['view']}}/?id="+obj.data.id
            });
        }
        
    });

});
</script>
@endsection