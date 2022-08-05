@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
<body class="pear-container">
<div class="layui-card">
    <div class="layui-card-body">
        <blockquote class="layui-elem-quote">
            说明:<br>
            1.修改权限任意数据， 需要再次登录，才能有效。
          </blockquote>
    </div>
</div>
<div class="layui-card">

    <div class="layui-card-body">
        
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">关键字</label>
                <div class="layui-input-inline">
                    <input type="text" name="keyword" placeholder="" class="layui-input">
                </div>
                <button class="pear-btn pear-btn-md pear-btn-primary" lay-submit lay-filter="power-query">
                    <i class="layui-icon layui-icon-search"></i>
                    查询
                </button>
                <button type="reset" class="pear-btn pear-btn-md">
                    <i class="layui-icon layui-icon-refresh"></i>
                    重置
                </button>
            </div>
        </form>
    </div>
</div>

<div class="layui-card">
    <div class="layui-card-body">
        <table id="power-table" lay-filter="power-table"></table>
    </div>
</div>

<script type="text/html" id="power-toolbar">
	<button class="pear-btn pear-btn-primary pear-btn-md" lay-event="expandAll">
	    <i class="layui-icon layui-icon-spread-left"></i>
	    展开
	</button>
	<button class="pear-btn pear-btn-primary pear-btn-md" lay-event="foldAll">
	    <i class="layui-icon layui-icon-shrink-right"></i>
	    折叠
	</button>
	<button class="pear-btn pear-btn-primary pear-btn-md" lay-event="reload">
	    <i class="layui-icon layui-icon-refresh"></i>
	    重载
	</button>
</script>

<script type="text/html" id="power-bar">
    <button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
</script>

</body>
@endsection
@section('js')
<script>
    layui.use(['table','form','jquery','treetable'],function () {
        let table = layui.table;
        let form = layui.form;
        let $ = layui.jquery;
        let treetable = layui.treetable;

        treetable.render({
                treeColIndex: 1,
                treeSpid: 0,
                method : 'post',
                treeIdName: 'id',
                treePidName: 'p_id',
                skin:'line',
                treeDefaultClose: true,
                toolbar:'#power-toolbar',
                elem: '#power-table',
                url: "{{$route['list']}}",
                page: false,
                cols:[
                    [
                        {type: 'checkbox'},
                    {
                        field: 'title', 
                        minWidth: 200, 
                        title: '权限名称'
                    },
                    {
                        field: 'icon', 
                        title: '图标',
                        templet : function(d){
                            return '<i class="'+d.icon+'"</i>';
                        }
                    },
                    {
                        field: 'type', 
                        title: '权限类型',
                        templet:function(d){
                            return (d.type == 0)?'目录':'菜单';
                        }
                    },
                    {
                        field: 'sort', 
                        title: '排序',
                    },
                    {
                        field: 'status', 
                        title: '是否可用',
                        templet:function(d){
                            let check = (d.status)?'checked=" "':'';
                            return   '<input type="checkbox" name="status" id="'+d.id+'" value="'+d.status+'" lay-skin="switch" lay-text="启用|禁用" lay-filter="auth_status" '+check+'/>';

                        }
                    },
                    {
                        title: '操作',
                        templet: '#power-bar', 
                        width: 150, 
                        align: 'center'
                    }
                    ]
                ]
            
        });

        table.on('tool(power-table)',function(obj){
            if (obj.event === 'edit') {
                window.edit(obj);
            }
        })

        table.on('toolbar(power-table)', function(obj){
            if(obj.event === 'add'){
                window.add();
            } else if(obj.event === 'refresh'){
                window.refresh();
            } else if(obj.event === 'expandAll'){
				 treetable.expandAll("#power-table");
			} else if(obj.event === 'foldAll'){
				 treetable.foldAll("#power-table");
			} else if(obj.event === 'reload'){
				 treetable.reload("#power-table");
			}
        });
		
		form.on('submit(power-query)', function(data) {
            var keyword = data.field.keyword;
            treetable.search('#power-table',keyword);
            return false;
		});

        window.edit = function(obj){
            layer.open({
                type: 2,
                title: '修改',
                shade: 0.1,
                area: ['450px', '500px'],
                content: "{{$route['update_view']}}/?id="+obj.data.id
            });
        }
        form.on('switch(auth_status)', function(obj){
            var data = { 
                "id":obj.elem.id,
                "status": (obj.value == 1)?0:1
            };
            msg(post("{{$route['status']}}",data));   
            window.refresh(); 
        })

        window.refresh = function(param) {
            treetable.reload("#power-table");
        }
		
       
    })
</script>
@endsection
