<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <div class="container-sm">
        <div class="container-sm">
            <h5>
                Login
            </h5>
            <?php echo form_open('user/login'); ?>
            <?php echo validation_errors(); ?>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" id="email" aria-describedby="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <h5 class="mt-10">
                <p>Don't have an account? </p>
                <a href="<?php echo site_url('user/register'); ?>" class="btn btn-success">Register</a>
            </h5>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>