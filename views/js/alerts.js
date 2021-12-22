const ajax_forms = document.querySelectorAll(".ajaxForm");

function send_ajax_form(e){
    e.preventDefault();
}

ajax_forms.forEach(forms => {
    forms.addEventListener("submit", send_ajax_form);

});

function ajax_alerts(alert){
    if(alert.Alert==="simple"){
        Swal.fire({
            icon: alert.Type,
            title: alert.Title,
            text: alert.Text,
            confirmButtonText:'Accept'
        });
    }else if(alert.Alert==="reload"){
        Swal.fire({
            icon: alert.Type,
            title: alert.Title,
            text: alert.Text,
            confirmButtonText:'Accept'
          }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
          });

    }else if(alert.Alert==="clean"){
        Swal.fire({
            icon: alert.Type,
            title: alert.Title,
            text: alert.Text,
            confirmButtonText:'Accept'
          }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(".ajaxForm").reset();
            }
          });
    }else if(alert.Alert==="redirect"){
        window.location.href=alert.URL;
    }
}
