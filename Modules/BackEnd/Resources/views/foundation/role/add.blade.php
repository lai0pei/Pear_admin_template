@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
	<body>
		<form class="layui-form" onsubmit="event.preventDefault();" >
			<div class="mainBox">
				<div class="main-container">
					<div class="layui-form-item">
						<label class="layui-form-label">组合名称</label>
						<div class="layui-input-block">
							<input type="text" name="role_name" lay-verify="required" autocomplete="off" placeholder="请输入账号"
								class="layui-input">
						</div>
					</div>
                    <div class="layui-form-item">
						<label class="layui-form-label">权限范围</label>
						<div class="layui-input-block">
                            @foreach ($data['auth_id'] as $key => $item)
                            <input type="checkbox" name="auth_id" value="{{$item['id']}}" title="{{$item['title']}}">
                            @endforeach
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">描述</label>
						<div class="layui-input-block">
							<textarea type="text" name="description" autocomplete="off" placeholder="请输入昵称"
								class="layui-textarea"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="bottom">
				<div class="button-container">
					<button type="submit" class="pear-btn pear-btn-primary pear-btn-sm" lay-submit=""
						lay-filter="user-save">
						<i class="layui-icon layui-icon-ok"></i>
						提交
					</button>
					<button type="reset" class="pear-btn pear-btn-sm">
						<i class="layui-icon layui-icon-refresh"></i>
						重置
					</button>
				</div>
			</div>
		</form>
@endsection
@section('js')
<script>
    layui.use(['form', 'jquery'], function() {
        let form = layui.form;
        let $ = layui.jquery;

        form.on('submit(user-save)', function(data) {
			let auth_id = [];
			$("input:checkbox[name='auth_id']:checked").each(function(i,v){
				auth_id.push($(this).val());
			});
			data.field.auth_id = auth_id;
			msg(post("{{$route['add']}}",data.field),true);
    })
});
</script>
@endsection
