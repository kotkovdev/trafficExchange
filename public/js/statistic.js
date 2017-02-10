window.onload = function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var client = {};
    $.get("http://ipinfo.io", function(response) {
        client.location = response;
        client.location.url = location.href;
        client.location.referer = document.referrer;
        if(getCookie('client') === undefined){
            var timestamp = new Date().getTime();
            document.cookie = 'client='+timestamp+client.location.ip;
        }
        $.ajax({
            url: '/statistic',
            type: 'post',
            data: client.location,
            success:function(response){

            }
        });
    }, "jsonp");

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
}