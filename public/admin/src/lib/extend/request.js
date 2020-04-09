layui.define(['jquery', 'packet', 'layer', 'view'], function (exports) {

    let $ = layui.jquery;
    let setter = layui.setter;
    let packet = layui.packet;
    let req = setter.request;
    let layer = layui.layer;
    let response = setter.response;
    let view = layui.view;

    let request = {
        post(url, data, done) {
            this.send({
                url: url,
                data: data,
                done: done,
                type: "post"
            });
        },
        /**
         * 发送AJAX请求
         * @param options
         */
        send(options) {
            if (options.data instanceof Object) {
                options.data = this.JSONObjectToParams(options.data);
            }

            let data = packet.pack(options.data);

            options.data = {
                _s: data[1],
                _v: data[2],
                _x: data[0]
            }

            options.headers = options.headers || {};

            if (req.tokenName) {
                options.headers[req.tokenName] = req.tokenName in options.headers
                    ? options.headers[req.tokenName]
                    : (layui.data(setter.tableName)[req.tokenName] || '');
            }

            $.ajax($.extend({
                type: "get",
                dataType: 'json',
                success: function (data) {
                    let unpack = packet.unpack(data._x, data._s, data._v);
                    let jsonObject = JSON.parse(unpack);
                    let statusCode = response.statusCode;
                    console.log(jsonObject);

                    if (jsonObject[response.statusName] == statusCode.ok) {
                        typeof options.done === 'function' && options.done(jsonObject);
                    } else if (jsonObject[response.statusName] == statusCode.logout) {
                        view.exit();
                    } else {
                        var errorText = [
                            (jsonObject[response.msgName] || '返回状态码异常')
                        ].join('');
                        layer.msg(errorText);
                    }
                }, error: function (e, code) {
                    var errorText = [
                        '请求异常，请重试<br><cite>错误信息：</cite>' + code
                    ].join('');
                    layer.msg(errorText);
                }
            }, options));
        },

        /**
         * 将对象转为query参数
         * @return {string}
         */
        JSONObjectToParams(obj) {
            let params = '';
            for (let key in obj) {
                if (obj[key] instanceof Array) {
                    obj[key].forEach(val => {
                        params += key + "[]=" + val + "&";
                    });
                } else if (obj[key] instanceof Object) {
                    for (sKey in obj[key]) {
                        params += key + "[" + sKey + "]=" + obj[key][sKey] + "&";
                    }
                } else {
                    params += key + "=" + obj[key] + "&";
                }
            }
            return params.substr(0, params.length - 1);
        }
    };

    exports('request', request);
});