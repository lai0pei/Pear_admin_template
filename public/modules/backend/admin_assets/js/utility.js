

function post(route,data){
    let result ;
    layui.use(['jquery'], function() {
        var $ = layui.jquery;
        result = $.ajax({
            type: "POST",
            url: route,
            data: JSON.stringify(data),
            dataType: 'json',
            contentType: 'application/json',
            async : false,
          }).responseJSON;
    });
    let tokenExpire = (result.response == undefined)? 0 : result.response.code;
    if(tokenExpire == 2){
        window.location.reload();
    }
    return result;
}

function msg(response,refresh = false){
    layui.use(['popup'],function(){
        var popup = layui.popup;
        var code = (response == undefined) ? 0 : response.code;
        var message = (response == undefined) ? '接口异常' : response.msg ;
        if (code) {
            popup.success(message, function() {
                if(refresh){
                    parent.layer.close(parent.layer.getFrameIndex(window
                        .name)); //关闭当前页
                    parent.window.refresh();
                }
            });
        } else { 
            popup.failure(message, function() {
                if(refresh){
                    parent.layer.close(parent.layer.getFrameIndex(window
                        .name)); //关闭当前页
                    parent.window.refresh();
                }
            });
        }
    })
}

