<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheeze</title>
    <link rel="stylesheet" href="route/view/resource/css/style.css">
</head>
<body>
    <nav>
        <div class="container">
            <a href="#" style="float: left;">Cheeze v1</a>
            <a href="" class="nav-item">Contact</a>
            <a href="" class="nav-item">About</a>
        </div>
    </nav>
    <header>
        <div>
            <h1>Cheeze</h1>
            <p>Simple & User-Friendly Content Management System</p>
            <a href="#" id="start">Let's Started</a> <a href="#" id="config">Configuration</a>
        </div>
    </header>
    <div class="wrapper">
        <div class="desc">
            <h2>.env Configuration</h2>
            Before installation, make sure the .env is properly configured
        </div>
        <div class="card-code">
            <div class="header">
                <i class="fa-solid fa-circle" style="color: rgb(255, 77, 77);"></i>
                <i class="fa-solid fa-circle" style="color: rgb(255, 255, 122);"></i>
                <i class="fa-solid fa-circle" style="color: rgb(66, 231, 66);"></i>
            </div>
            <table>
                <?php
                $i = 0;
                while (!feof($data['env_file'])) {
                    $i += 1;
                    $line = fgets($data['env_file']);
                    echo '<tr>
                    <td class="col">'.$i.'</td>
                    <td>'.$line.'</td>
                    </tr>';
                }
                ?>
            </table>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/e42e6d5e29.js" crossorigin="anonymous"></script>
</body>
</html>