
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

$( document ).ready(function() {


  if (document.getElementById("msg") != null){
    var msg = document.getElementById("msg").value
    var title = document.getElementById("title").value
    var type = document.getElementById("type").value

    toastr.success(msg, title , {timeOut: 5000})
      toastr.options = {
      "closeButton": true,
      "debug": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  }


});
</script>
