window.onload = function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var client = {};
    $.get("http://ipinfo.io", function(response) {
        client.location = response;
        console.log(client.location);
        $.ajax({
            url: '/statistic',
            type: 'post',
            data: client.location,
            success:function(response){

            }
        });
    }, "jsonp");
}