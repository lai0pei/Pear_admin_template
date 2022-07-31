@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
	<body>
		<form class="layui-form" onsubmit="event.preventDefault();" >
			<div class="mainBox">
				<div class="main-container">
					<div class="layui-form-item">
						<label class="layui-form-label">账号</label>
						<div class="layui-input-block">
							<input type="text" name="account" lay-verify="required|account" autocomplete="off" placeholder="请输入账号" lay-reqtext="请填写账号"
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">昵称</label>
						<div class="layui-input-block">
							<input type="text" name="username" lay-verify="required" autocomplete="off" placeholder="请输入昵称" lay-reqtext="请填写昵称"
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">密码</label>
						<div class="layui-input-block">
							<input type="text" name="password" lay-verify="required|password" autocomplete="off" placeholder="请输入密码" 
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">电话</label>
						<div class="layui-input-block">
							<input type="text" name="number" autocomplete="off" placeholder="请输入电话"
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">性别</label>
						<div class="layui-input-block">
							<input type="radio" name="sex" value="1" title="男">
							<input type="radio" name="sex" value="0" title="女" checked>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">管理员角色</label>
						<div class="layui-input-block">
						<select name="role_id">
                            @foreach($data['role'] as $value)
                            <option value="{{$value['id']}}">{{$value['role_name']}}</option>
                            @endforeach
                        </select>
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
    layui.use(['form', 'jquery', 'popup'], function() {
        let form = layui.form;
        let $ = layui.jquery;
		let popup = layui.popup;

		// 表单验证
		form.verify({
                account: function(value) {
                    if (value.length > 11) {
                        popup.failure("账号不能超过11个字符");
                        return true;
                    }
                },
                password: function(value) {
                    if (value.length < 5) {
                        popup.failure("密码不能少于5个字符");
                        return true;
                    }

                    if (value.length > 20) {
                        popup.failure("密码不能超过20个字符");
                        return true;
                    }
                },

            })

        form.on('submit(user-save)', function(data) {
			msg(post("{{$route['add']}}",data.field),true);
    })
});
</script>
@endsection
