@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
	<body>
		<form class="layui-form" onsubmit="event.preventDefault();" lay-filter="user-form" >
			<div class="mainBox">
				<div class="main-container">
					<div class="layui-form-item">
						<label class="layui-form-label">账号</label>
						<div class="layui-input-block">
							<input type="text" name="account" value="{{$data['data']['account'] ?? ''}}" lay-verify="required" autocomplete="off"
								class="layui-input" disabled>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">姓名</label>
						<div class="layui-input-block">
							<input type="text" name="username" value="{{$data['data']['username'] ?? ''}}" lay-verify="required" autocomplete="off" 
								class="layui-input" disabled>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">电话</label>
						<div class="layui-input-block">
							<input type="text" name="number" value="{{$data['data']['number'] ?? ''}}" autocomplete="off" 
								class="layui-input" disabled>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">性别</label>
						<div class="layui-input-block">
							<input type="radio" name="sex" id="male" value="1" title="男" {{($data['data']['sex'] == 1)?"checked=''":''}} disabled>
							<input type="radio" name="sex" id="female" value="0" title="女" {{($data['data']['sex'] == 0)?"checked=''":''}} disabled>
						</div>
					</div>
                    <div class="layui-form-item">
						<label class="layui-form-label">管理员角色</label>
						<div class="layui-input-block">
						<select name="role_id" disabled>
                            @foreach($data['role'] as $value)
							@if($value['id'] == $data['data']['role_id'])
                            <option value="{{$value['id']}}">{{$value['role_name']}}</option>
							@endif
                            @endforeach
                        </select>
						</div>
					</div>
				</div>
			</div>
		</form>
@endsection

