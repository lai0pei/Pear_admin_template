@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')
	<body>
		<form class="layui-form" onsubmit="event.preventDefault();" lay-filter="user-form" >
			<div class="mainBox">
				<div class="main-container">
					<div class="layui-form-item">
						<label class="layui-form-label">原因</label>
						<div class="layui-input-block">
                            <textarea placeholder="无内容" class="layui-textarea">{{$data['data']['content'] ?? ''}}</textarea>
						</div>
					</div>
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

});
</script>
@endsection
