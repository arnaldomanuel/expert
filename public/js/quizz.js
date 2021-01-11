


function calc() {
    var resultado = 0;
    quizzes.forEach(element => {
        var radios = document.getElementsByName('pergunta' + element.id);
        let answer;
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                answer = radios[i].value;
                break;
            }
        }
        if (answer == element.correct_index) {
            resultado += 1;
        }
    });
    $('#resultPoints').html(resultado*10)
    $('#slideTotalPoints').html(slideTotal*10)


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var formData = {
        user_id1 : user_id,
        module_id1 : module_id,
        result : resultado*10,
        total_count: slideTotal*10,
    };
    console.log(formData);
    var type = "POST";
    var ajaxurl = "/quizz/result";

    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: function (data) {
            if (resultado*10>=slideTotal*5) {
                $('#sucess').show()
                $('#failure').hide()
            } else {
                $('#sucess').hide()
                $('#failure').show()
            }
          
            var instance = M.Modal.getInstance(document.getElementById("modal1"));
            instance.open()

           console.log('oli');
            console.log(data);
        },
        error: function (error) {
            console.log(error);
            console.log("err");
            
            if (error.status == 401) {
                window.location.href = "/login"
            }
        }
    });


}


document.addEventListener('DOMContentLoaded', function () {
    var elems1 = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems1, {
      
        onCloseEnd: function(){
            console.log('close');
            window.location.href="/my-results/quizz"
        },
    });
    $('#slideTotal').html(slideTotal)
  
    var elems = document.querySelectorAll('.carousel');
     instances = M.Carousel.init(elems, {
        noWrap:true,
        fullWidth: true,
        indicators: true,
        
    });
});

function next() {
    var instance = M.Carousel.getInstance(document.getElementById('carousel'));
    slideId++;

    if (slideId > slideTotal) {
        slideId = 1
    }
    $('#slideId').html(slideId)
    instance.next();
}
function prev() {
    var instance = M.Carousel.getInstance(document.getElementById('carousel'));
    slideId--;
    if (slideId <= 0) {
        slideId = slideTotal
    }
    $('#slideId').html(slideId)
    instance.prev();
}
