<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jCAPTCHA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <style>

        #txtCaptcha {
            border: 0px;
            border-top: 1px solid rgba(0,0,0,.125);
            border-radius: 0px;
        }

    </style>
</head>

<body class="bg-dark">
    <div class="container bg-white mt-5 p-5 rounded">
        <h1 class="text-center mb-4">jCAPTCHA</h1>

        <form action="./backend.php" method="POST">
            <div class="mb-3">
                <label for="txtEmail" class="form-label">Email Address:</label>
                <input type="text" class="form-control" id="txtEmail" value="johnsmith@email.com" required>
            </div>

            <div class="mb-3">
                <label for="txtMsg" class="form-label">Message:</label>
                <textarea class="form-control" id="txtMsg" rows="3" required>This message doesn't actually get sent or saved anywhere. It is merely a practical demonstration of what this CAPTCHA library could be used for.</textarea>
            </div>

            <div class="mb-3">
                <div class="card" style="width: 20rem;">
                    <img id="imgCaptcha" src="./generate.php" class="card-img-top" alt="...">
                    <div class="card-body p-0">
                        <input type="text" class="form-control" id="txtCaptcha" placeholder="Type the 5 Characters..." required>
                    </div>
                </div>
                <small><a href="#" id="btnNewCaptcha">Regenerate CAPTCHA</a></small>
            </div>

            <button type="submit" class="btn btn-primary">Submit Message!</button>
        </form>

        <div class="border-top border-bottom mt-5 p-2 text-center" style="display: none" id="result">
            <h2>That is correct!</h2>
            <p class="m-0">The CAPTCHA's text was: <strong>TEST</strong></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"
        integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous">
    </script>

    <script>

        let regenCount = 1;

        $('form').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: './backend.php',
                type: 'POST',
                data: {
                    'txtEmail': $('#txtEmail').val(),
                    'txtMsg': $('#txtMsg').val(),
                    'txtCaptcha': $('#txtCaptcha').val()
                },
                success: function (res) {
                    let element = $('#result');

                    if (res == 'true')
                    {
                        element.find('h2').html("That was correct!");
                        element.find('p').html("The CAPTCHA's text was: <strong>" + $('#txtCaptcha').val() + "</strong>");
                    }
                    else
                    {
                        element.find('h2').html("That was incorrect!");
                        element.find('p').html("The CAPTCHA's text was: <strong>" + res + "</strong>");
                    }

                    element.show();
                }
            });
        });

        $('#btnNewCaptcha').click(function (e) {
            e.preventDefault();

            if (regenCount > 5)
                $('#btnNewCaptcha').remove();
            else
            {
                $('#imgCaptcha').attr('src', './generate.php');
                regenCount++;
            }
        });

    </script>
</body>

</html>