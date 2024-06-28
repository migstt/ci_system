<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Jconfirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- custom scripts -->
    <script>
        // for signing in
        $(document).on('submit', 'form[id^="signInForm"]', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url(); ?>/user/login/",
                data: form.serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    if (response.status == "error") {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        return;
                    } else if (response.status == "success") {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(function() {
                            window.location.href = "<?php echo site_url('contacts'); ?>";
                        }, 1500);
                    }
                },
                error: function(xhr, status, error, response) {
                    response = JSON.parse(response);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return;
                    console.error('AJAX ERROR: ' + xhr.responseText);
                    console.error('SIGNIN ERROR: ' + error);
                }
            });
        });
    </script>

    <!-- custom styles -->
    <style>
        .container-sm {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-success {
            width: 100%;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .container-sm {
            margin-top: 100px;
        }
    </style>

</head>

<body>

    <div class="container-sm">
        <h5>
            Sign in
        </h5>
        <?php echo form_open('user/login', array('id' => 'signInForm')); ?>
        <?php echo validation_errors(); ?>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" id="email" aria-describedby="email">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
        <h5 class="mt-10">
            <p>Don't have an account? </p>
            <a href="<?php echo site_url('register'); ?>" class="btn btn-success">Register</a>
        </h5>
    </div>

</body>

</html>