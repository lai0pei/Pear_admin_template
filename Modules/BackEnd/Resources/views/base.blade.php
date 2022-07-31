<!DOCTYPE html>
<html lang="cn">
<head>
    @php
        $name = config('app.title');
        $trademark = '2022 - 2025';
    @endphp
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1, minimun-scale=1, user-scalable=0">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 依 赖 脚 本 -->
    <script src="{{ asset($pear_asset . '/component/layui/layui.js') }}"></script>
    <script src="{{ asset($pear_asset . '/component/pear/pear.js') }}"></script>
    <!-- 请求脚本 -->
    <script src="{{ asset($admin_asset . '/js/utility.js') }}"></script>
    @yield('head')
</head>
@yield('body')
<script>
    var animation = {
        "loading": 500,
    };
    layui.use(['jquery'], function() {
        var $ = layui.jquery;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@yield('js')

</html>
