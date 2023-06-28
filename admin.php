
<!DOCTYPE html>
<html>
	<head>
		<?php include('header.php') ?>
        <?php 
        // session_start();
        // if(isset($_SESSION['login_id'])){
        //     header('Location:home.php');
        // }
        ?>
		<title>Admin Login |Bus Booking</title>
	</head>
    <style>
        body {
    background-image: url(./assets/img/bus.jpg);
    height: 96vh;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
    </style>
	<body id='login-body' class="bg-light">
    		<div class="card col-md-4 offset-md-4 mt-4">
                <div class="card-header-edge text-white">
                    <strong>Login</strong>
                </div>
            <div class="card-body">
                     <form id="login-frm">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="username" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div> 
                        <div class="form-group text-right">
                            <button class="btn btn-primary btn-block" name="submit">Login</button>
                        </div>
                        
                    </form>
            </div>
        </div>

		</body>

        <script>
            $(document).ready(function(){
                $('#login-frm').submit(function(e){
                    e.preventDefault()
                    $('#login-frm button').attr('disable',true)
                    $('#login-frm button').html('Please wait...')

                    $.ajax({
                        url:'./login_auth.php',
                        method:'POST',
                        data:$(this).serialize(),
                        error:err=>{
                            console.log(err)
                            alert('An error occured');
                            $('#login-frm button').removeAttr('disable')
                            $('#login-frm button').html('Login')
                        },
                        success:function(resp){
                            if(resp == 1){
                                location.replace('index.php?page=home')
                            }else{
                                alert("Incorrect username or password.")
                                $('#login-frm button').removeAttr('disable')
                                $('#login-frm button').html('Login')
                            }
                        }
                    })

                })
            })
        </script>
</html>