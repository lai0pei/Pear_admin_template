@extends("{$module}::base")
<!-- 依 赖 样 式 -->
<link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
@section('body')

    <body>
        <form class="layui-form" onsubmit="event.preventDefault();" lay-filter="user-form">
            <div class="mainBox">
                <div class="main-container">
                    <div class="layui-form-item">
                        <input type="hidden" value="{{ $data['data']['id'] ?? 0 }}" name="id" />
                        <label class="layui-form-label">权限名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" value="{{ $data['data']['title'] ?? '' }}"
                                lay-verify="required|title" autocomplete="off" placeholder="请输入账号" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">上级菜单</label>
                        <div class="layui-input-block">
                           <select name="p_id">
                            @if ($data['auth'] == [])
                            <option value="0">无上级</option>
                            @else
                            @foreach ($data['auth']['auth_menu'] as $v)
                            @if ($data['auth']['upLevel'] == $v['id'])
                            <option value="{{$v['id']}}" selected>{{$v['title']}}</option>
                            @else
                            <option value="{{$v['id']}}">{{$v['title']}}</option>
                            @endif
                            @endforeach 
                            @endif
                           </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">选择图标</label>
                        <div class="layui-input-block">
                            <input type="text" name="icon" id="iconPicker" class="myIcon" value="{{ $data['data']['icon'] ?? '' }}" style="display:none" lay-filter="iconPicker" />
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">排序</label>
                        <div class="layui-input-block">
                            <input type="text" name="sort" value="{{ $data['data']['sort'] ?? '' }}"
                                lay-verify="required|sort" autocomplete="off" placeholder="请输入排序" class="layui-input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="button-container">
                    <button type="submit" class="pear-btn pear-btn-primary pear-btn-sm" lay-submit=""
                        lay-filter="auth-save">
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
            layui.use(['iconPicker','form', 'jquery', 'popup'], function() {
                let iconPicker = layui.iconPicker;
                let form = layui.form;
                let $ = layui.jquery;
                let popup = layui.popup;
                

                iconPicker.render({
                    elem: '#iconPicker',
                    type: 'fontClass',
                    search: true,
                    page: false,
                    limit: 16,
                    click: function(data) {
                        $('.myIcon').val('layui-icon '+data.icon)
                    },
                    success: function(d) {
                       
                    }
                });

                // 表单验证
                form.verify({
                    title: function(value) {
                        if (!(value.length > 0 && value.length < 10)) {
                            popup.failure("不能超过10个字符");
                            return true;
                        }
                    },
                    sort: function(value) {
                        if (value.length > 5) {
                            popup.failure("排序值不能太大");
                            return true;
                        }
                    },


                })
                form.on('submit(auth-save)', function(data) {
                    msg(post("{{ $route['update'] }}", data.field), true);
                })
            });
        </script>
    @endsection
