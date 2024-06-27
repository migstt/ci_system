<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom styles -->
    <style>
        /* Add your custom styles here */
        .container-sm {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
            margin-top: 50px;
        }

        h1 {
            color: #333;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }
    </style>

</head>

<body>

    <div class="container-sm">
        <h1>Thank you!</h1>
        <a href="<?php echo site_url('contact/contacts'); ?>" class="btn btn-success">Continue</a>
    </div>

</body>

</html>