<?php

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    function validate(array $data)
    {
        $errors = [];
        if (isset($data['name'])) {
            $name = $data['name'];
            if (empty($name)) {
                $errors['name'] = 'Введите Name';
            } elseif (strlen($name) < 4) {
                $errors['name'] = 'Поле Name имеет менее 4 символов';
            }
        } else {
            $errors['name'] = 'Введите Name';
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (empty($email)) {
                $errors['email'] = 'Введите email';
            } elseif (strlen($email) < 4) {
                $errors['email'] = 'Поле email имеет менее 4 символов';
            } elseif (!strpos($email, '@')) {
                $errors['email'] = "Некоректное заполнение поля email, нет символа @";
            }
        } else {
            $errors['email'] = 'Введите email';
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (empty($password)) {
                $errors['psw'] = 'Введите поле password';
            } elseif (strlen($password) < 4) {
                $errors['psw'] = 'Поле password имеет менее 4 символов';
            }
        } else {
            $errors['psw'] = 'Введите поле password';
        }

        if (isset($data['psw-repeat'])) {
            $repeatPassword = $data['psw-repeat'];
            if (empty($repeatPassword)) {
                $errors['psw-repeat'] = 'Введите поле Repeat Password';
            } elseif ($repeatPassword !== $password) {
                $errors['psw'] = 'Пароли не совподают';
            }
        } else {
            $errors['psw-repeat'] = 'Введите поле repeat password';
        }
        return $errors;
    }
    $errors = validate($_POST);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['psw'];
        $repeatPassword = $_POST['psw-repeat'];

        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $pdo->prepare(query: 'INSERT INTO users ( name, email, password) VALUES (:name, :email, :password)');
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
        $stmt = $pdo->prepare(query: 'SELECT * FROM users WHERE name = :name');
        $stmt->execute(['name' => $name]);
        $data = $stmt->fetch();
        header("location: /login.php");
    }
}

?>

<form action="" method="post">
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <?php if(isset($errors['name'])): ?>
            <label style="color: red"> <?php echo $errors['name']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter Name" name="name" id="name" >

        <label for="email"><b>Email</b></label>
        <?php if(isset($errors['email'])): ?>
            <label style="color: red"> <?php echo $errors['email'] ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter Email" name="email" id="email" >

        <label for="password"><b>Password</b></label>
        <?php if(isset($errors['psw'])): ?>
            <label style="color: red"> <?php echo $errors['psw'] ?></label>
        <?php endif; ?>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" >

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <?php if(isset($errors['psw-repeat'])): ?>
            <label style="color: red"> <?php echo $errors['psw-repeat'] ?></label>
        <?php endif; ?>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" >
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="#">Sign in</a>.</p>
    </div>
</form>
<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>
