//生成gif
var is_click = false;
$(document).on('click', '#make-gif', function(event) {
    if(is_click){
        return;
    }
    is_click = true;

    var data = [];
    var all_input = $('#form-wrap input');
    for (var i = 0; i < all_input.length; i++) {
        data[i] = $(all_input[i]).val();
    }

    var name = $(this).attr('name');
    $.post(
        'api.php', 
        {
            data: data,
            name: name
        }, 
        function(res) {
            console.log(res);
            if(res.success == true){
                var src = '.'+res.data;
                var href = 'download.php?id='+encodeURI(res.data);
                $("#img-preview img").attr('src', src);
                $("#img-preview a").attr('href', href);
                $("#img-preview").show();

            }else{
                if(res.success == false){
                    alert(res.data);
                }else{
                    // alert('服务异常！');
                }
            }
            is_click = false;
            return;
        }
    );
});