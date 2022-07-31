@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
    <body class="pear-container">
        <div class="layui-card">
            <div class="layui-card-body">
                <blockquote class="layui-elem-quote">
                    说明:<br>
                    1.请先添加 管理员组合。<br>
                    2.后添加 管理员。
                  </blockquote>
            </div>
        </div>
        <div class="layui-card">
			<div class="layui-card-body">
				<form class="layui-form" action="">
					<div class="layui-form-item">
						<div class="layui-form-item layui-inline">
							<label class="layui-form-label">账号</label>
							<div class="layui-input-inline">
								<input type="text" name="account" placeholder="" class="layui-input">
							</div>
						</div>
						<div class="layui-form-item layui-inline">
							<label class="layui-form-label">昵称</label>
							<div class="layui-input-inline">
								<input type="text" name="username" placeholder="" class="layui-input">
							</div>
						</div>
						<div class="layui-form-item layui-inline">
							<label class="layui-form-label">性别</label>
							<div class="layui-input-inline">
								<select name="sex">
                                    <option value="">请选择性别</option>
                                    @foreach ($data['sex'] as $item)
                                        <option value="{{$item['value']}}">{{$item['text']}}</option>
                                    @endforeach
                                </select>
							</div>
						</div>
						<div class="layui-form-item layui-inline">
							<button class="pear-btn pear-btn-md pear-btn-primary" lay-submit lay-filter="user-query">
								<i class="layui-icon layui-icon-search"></i>
								查询
							</button>
							<button type="reset" class="pear-btn pear-btn-md">
								<i class="layui-icon layui-icon-refresh"></i>
								重置
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

        <div class="layui-card">
			<div class="layui-card-body">
				<table id="user-table" lay-filter="user-table"></table>
			</div>
		</div>

        <script type="text/html" id="user-toolbar">
			<button class="pear-btn pear-btn-primary pear-btn-md" lay-event="add">
		        <i class="layui-icon layui-icon-add-1"></i>
		        新增
		    </button>
		    <button class="pear-btn pear-btn-danger pear-btn-md" lay-event="batchRemove">
		        <i class="layui-icon layui-icon-delete"></i>
		        删除
		    </button>
		</script>

        <script type="text/html" id="user-bar">
			<button class="pear-btn pear-btn-primary pear-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
		    <button class="pear-btn pear-btn-danger pear-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
		</script>

    </body>
@endsection
@section('js')
<script>
    layui.use(['table', 'form', 'jquery','common','popup'], function() {
        let table = layui.table;
        let form = layui.form;
        let $ = layui.jquery;
        let common = layui.common;
        let popup = layui.popup;

        let cols = [
            [   {
                    type: 'checkbox'
                },
                {
                    title: '编号',
                    field: 'id',
                    align: 'center',
                    sort : true,
                 
                },
                {
                    title: '账号',
                    field: 'account',
                    align: 'center',
                   
                },
                {
                    title: '姓名',
                    field: 'username',
                    align: 'center',
                 
                },
                {
                    title: '性别',
                    field: 'sex',
                    align: 'center',
                    sort : true,
                    templet : function(d){
                            return ((d.sex) == '' || (d.sex) == 1)?'男':'女';
                    }
                },
                {
                    title: '电话',
                    field: 'phone',
                    align: 'center'
                },
                {
                    title: '状态',
                    field: 'status',
                    align: 'center',
                    sort : true,
                    width : 150,
                    templet : function(d){
                        let check = (d.status)?'checked=" "':'';
                        if(d.id != 1){
                            return   '<input type="checkbox" name="status" id="'+d.id+'" value="'+d.status+'" lay-skin="switch" lay-text="启用|禁用" lay-filter="admin_status" '+check+'/>';
                        }else{
                            return   '<input type="checkbox" disabled name="status" id="'+d.id+'" value="'+d.status+'" lay-skin="switch" lay-text="启用|禁用" lay-filter="admin_status" '+check+'/>';

                        }
                    }

                },
                {
                    title: '登录',
                    field: 'login_count',
                    align: 'center',
                    sort : true,
                    templet : function(d){
                           return d.login_count+'次'
                    }
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
            url: "{{$route['list']}}",
            page: true,
            cols: cols,
            skin: 'row',
            even : true,
            toolbar: '#user-toolbar',
            defaultToolbar: [{
                title: '刷新',
                layEvent: 'refresh',
                icon: 'layui-icon-refresh',
            }, 'filter', 'print', 'exports']
        });

        form.on('switch(admin_status)', function(obj){
            var data = { 
                "id":obj.elem.id,
                "status": (obj.value == 1)?0:1
            };
            var posts = post("{{$route['status']}}",data);
            msg(posts);   
            window.refresh(); 
        })

        table.on('tool(user-table)', function(obj) {
            if (obj.event === 'remove') {
                window.remove(obj);
            } else if (obj.event === 'edit') {
                window.edit(obj);
            }
        });

        table.on('toolbar(user-table)', function(obj) {
            if (obj.event === 'add') {
                window.add();
            } else if (obj.event === 'refresh') {
                window.refresh();
            } else if (obj.event === 'batchRemove') {
                window.batchRemove(obj);
            }
        });

        form.on('submit(user-query)', function(data) {
            table.reload('user-table', {
                where: {
                   searchParams : data.field,
                }
            })
            return false;
        });

        form.on('switch(user-enable)', function(obj) {
            layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
        });

        window.add = function() {
            layer.open({
                type: 2,
                title: '新增',
                shade: 0.1,
                area: [common.isModile()?'100%':'500px', common.isModile()?'100%':'600px'],
                maxmin: true,
                shadeClose: true,
                content: "{{$route['add_view']}}"
            });
        }

        window.edit = function(obj) {
            layer.open({
                type: 2,
                title: '修改',
                shade: 0.1,
                maxmin: true,
                shadeClose: true,
                area: [common.isModile()?'100%':'500px', common.isModile()?'100%':'600px'],
                content: "{{$route['update_view']}}/?id="+obj.data.id
            });
        }

        window.remove = function(obj) {
            layer.confirm('确定要删除该用户', {
                icon: 3,
                title: '提示'
            }, function(){
                msg(post("{{$route['delete']}}",{'id' : obj.data.id}));
                window.refresh();
            }
           );
        }

        window.batchRemove = function(obj) {
            
            var checkIds = common.checkField(obj,'id');
          
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
                msg(post("{{$route['delete']}}",{'id' : checkIds}));
                window.refresh();
            });
        }

        window.refresh = function(param) {
            table.reload('user-table');
        }
    })
</script>
@endsection
