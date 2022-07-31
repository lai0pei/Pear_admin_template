@extends("{$module}::base")
@section('head')
    <!-- 依 赖 样 式 -->
    <link rel="stylesheet" href="{{ asset($pear_asset . '/component/pear/css/pear.css') }}" />
    <link rel="stylesheet" href="{{ asset($admin_asset . '/css/login/login.css') }}" />

    <style>
        body {
            background-repeat: no-repeat;
            background-color: whitesmoke;
            background-size: 100%;
            height: 100%;
            background: url("{{ $data['images']['background'] }}");
        }

        @media (max-width:768px) {
            body {
                background-position: center;
                background: url("{{ $data['images']['background'] }}");
            }
        }
    </style>
@endsection
@section('body')

    <body style="background-size: cover;" alt="">
        <form class="layui-form" action="javascript:void(0);">
            <div class="layui-form-item">
                <img class="logo" src="{{ $data['images']['logo'] }}" alt="" />
                <div class="title">Pear Admin</div>
                <div class="desc">
                    明 湖 区 最 具 影 响 力 的 设 计 规 范 之 一
                </div>
            </div>
            <div class="layui-form-item">
                <input placeholder="账 户 : admin " lay-verify="required|account" lay-reqText="请填写账号" hover
                    class="layui-input" id="account" name="account" />
            </div>
            <div class="layui-form-item">
                <input placeholder="密 码 : admin " lay-verify="required|password" lay-reqText="请填写密码" hover
                    class="layui-input" id="password" name="password" />
            </div>
            <div class="layui-form-item">
                <input placeholder="验证码 : " hover lay-verify="required|captcha" lay-reqText="请填写验证码"
                    class="code layui-input layui-input-inline" id="captcha" name="captcha" />
                <img src="{{ $data['images']['captcha'] }}" class="codeImage" alt="" />
            </div>
            <div class="layui-form-item">
                <input type="checkbox" name="remember" title="记住密码" lay-skin="primary">
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>记住密码</span><i
                        class="layui-icon layui-icon-ok"></i></div>
            </div>
            <div class="layui-form-item">
                <button type="button" class="pear-btn pear-btn-success login" lay-submit lay-filter="login">
                    登 入
                </button>
            </div>
        </form>
    </body>
@endsection
@section('js')
    <script>
        layui.use(['form', 'button', 'popup', 'jquery'], function() {
            var form = layui.form;
            var button = layui.button;
            var popup = layui.popup;
            var $ = layui.jquery;

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
                captcha: function(value) {
                    if (value.length != 4) {
                        popup.failure("请输入正确的验证码");
                        return true;
                    }
                }

            })
            // 登 录 提 交
            form.on('submit(login)', function(data) {
                /// 登录
                $.post("{{ $route['login_action'] }}", data.field, function(data) {
                    /// 动画
                    button.load({
                        elem: '.login',
                        time: animation.loading,
                        done: function() {
                            if (data.code) {
                                popup.success(data.msg, function() {
                                    location.href = "{{ $route['to_home'] }}";
                                });
                            } else {
                                popup.failure(data.msg);
                            }

                        }
                    })
                });

                return false;
            });
        })
    </script>
@endsection
