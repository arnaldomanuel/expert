
var token;

function requestToken() {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var formData = {
        course_id : course_id,
    };
    $('#btnRequest').hide()
    $('#loader').show()
    var type = "POST";
    var ajaxurl = "/request/course-grant";

    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function (data) {
            token = data

            
            $('.token').html(token)
            $('#btnRequest').hide()
            $('#loader').hide()
            var instance = M.Modal.getInstance(document.getElementById("modal1"));
            instance.open()

        },
        error: function (error) {
            console.log(error);
            $('#btnRequest').show()
            $('#loader').hide()
            if (error.status == 401) {
                window.location.href = "/auth/sign-in"
            }
            if (error.status==403) {
                window.location.href = "/email/verify"
            }
        }
    });


}


document.addEventListener('DOMContentLoaded', function () {
    var elems1 = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems1, {});
    

});
