@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
	<body>
		<form class="layui-form" onsubmit="event.preventDefault();" lay-filter="user-form" >
			<div class="mainBox">
				<div class="main-container">
					<div class="layui-form-item">
                        <input type="hidden" value="{{$data['data']['id'] ?? 0}}" name="id"/>
						<label class="layui-form-label">账号</label>
						<div class="layui-input-block">
							<input type="text" name="account" value="{{$data['data']['account'] ?? ''}}" lay-verify="required|account" autocomplete="off" placeholder="请输入账号"
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">姓名</label>
						<div class="layui-input-block">
							<input type="text" name="username" value="{{$data['data']['username'] ?? ''}}" lay-verify="required" autocomplete="off" placeholder="请输入昵称"
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">密码</label>
						<div class="layui-input-block">
							<input type="text" name="password" autocomplete="off" lay-verify="password" placeholder="请输入新密码" lay-verify="password"
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">电话</label>
						<div class="layui-input-block">
							<input type="text" name="number" value="{{$data['data']['number'] ?? ''}}" autocomplete="off" placeholder="请输入电话"
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">性别</label>
						<div class="layui-input-block">
							<input type="radio" name="sex" id="male" value="1" title="男" {{($data['data']['sex'] == 1)?"checked=''":''}}>
							<input type="radio" name="sex" id="female" value="0" title="女" {{($data['data']['sex'] == 0)?"checked=''":''}}>
						</div>
					</div>
                    <div class="layui-form-item">
						<label class="layui-form-label">管理员角色</label>
						<div class="layui-input-block">
						<select name="role_id">
                            @foreach($data['role'] as $value)
							@if($value['id'] == $data['data']['role_id'])
                            <option value="{{$value['id']}}" selected>{{$value['role_name']}}</option>
							@else
							<option value="{{$value['id']}}">{{$value['role_name']}}</option>
							@endif
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
    layui.use(['form', 'jquery','popup'], function() {
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
                    if (value.length > 0 && value.length < 5) {
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
			msg(post("{{$route['update']}}",data.field),true);
    })
});
</script>
@endsection
