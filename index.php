<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Bus Booking</title>

</head>


<body>
<?php session_start() ?>
<?php

  header('index.php?page=home');
 include 'header.php'; ?>
<?php if(isset($_SESSION['login_id'])) include 'admin_navbar.php'; else include 'navbar.php'; ?>

<div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-body text-white">
  </div>
</div>

    <?php 
    if(isset($_GET['page']) && !empty($_GET['page']))
      include($_GET['page'].'.php');
    else
      include('home.php');

    ?>
   
    <div class="modal fadeIn" tabindex="-1" id="uni_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary submit" onclick="$('#uni_modal form').submit()">
              <?php echo isset($_SESSION['login_id']) ? 'Save' : 'Find' ?> 
          </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fadeIn" tabindex="-1" id="confirm_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="confirm" onclick="">Continue</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fadeIn" tabindex="-1" id="book_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

          </div>
          
        </div>
      </div>
    </div>

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container-fluid d-md-flex py-4">

      <div class="mr-md-auto text-center text-md-left">
        <div class="copyright">
          &copy; Copyright <strong><span><a href="https://www.sourcecodester.com/" target="_blank">soucecodester.com</a></span></strong>. All Rights Reserved
        </div>
      </div>
    </div>
  </footer>

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  <script src="assets/js/main.js"></script>

</body>
<script>
  window.uni_modal =  function($title='',$url='',$book = 0){
    $('#uni_modal .modal-title').html($title);
        start_load();

    $.ajax({
      url:$url,
      error:err=>console.log(err),
      success:function(resp){
        $('#uni_modal .modal-body').html(resp)
        if('<?php echo !isset($_SESSION['login_id']) ?>' == 1){
                if($book == 1){
                   $('#uni_modal .submit').html('Book')
                }else{
                   $('#uni_modal .submit').html('Find')
        
                }
              }
        $('#uni_modal .modal-footer').show()
        $('#uni_modal').modal('show')
      },
      complete:function(){
        end_load();

      }
    })
  }
  window._conf = function($msg='',$func='',$params = []){
     $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
     $('#confirm_modal .modal-body').html($msg)
     $('#confirm_modal').modal('show')
  }
  window.start_load = function(){
    $('body').prepend('<di id="preloader2"></di>')
  }
  window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      })
  }
  window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      $('#alert_toast').removeClass('bg-success')
      $('#alert_toast').removeClass('bg-danger')
      $('#alert_toast').removeClass('bg-info')
      $('#alert_toast').removeClass('bg-warning')

    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({delay:3000}).toast('show');
  }
  $(document).ready(function(){
  })
</script>
</html>