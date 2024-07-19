<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan of Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon_io/favicon.ico">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="error-page text-center">
                    <h3 class="display-3">Error Occurred</h3>
                    <?php
                    if (isset($_GET['message'])) {
                        $error_message = htmlspecialchars($_GET['message']);
                        echo "
                        <div class='alert alert-light' role='alert'>
                            <h4 class='alert-heading'>Error!</h4>
                            <p>$error_message</p>
                        </div>";
                    } else {
                        echo "<p class='text-danger'>An unexpected error occurred.</p>";
                    }
                    ?>
                    <a href="javascript:history.go(-1)" class="btn btn-dark mt-3">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
