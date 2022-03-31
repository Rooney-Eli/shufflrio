<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="login-style.css"/>
</head>
<body>

    <div class="page-north"></div>
    <div class="page-center">
        <div class="prompt-container">
            <div class="login">
                <form class="login-form" action="userLoginHandler.php" method="post">
                    <label id="banner-name">Shufflr</label>
                    <label id="banner-phrase">mix it up</label>

                    <label id="username-label" for="username-input"
                    ><?php if(isset($_SESSION['error-message'])) {
                            if($_SESSION['error-message'] == 'invalidUsername') {
                                unset($_SESSION['error-message']);
                                echo "Invalid username!";
                            }else{
                                echo "username";
                            }
                        }else{
                            echo "username";
                        }?></label>

                    <input
                            type="text"
                            id="username-input"
                            class="text-input-box"
                            name="username-input"
                            placeholder="..."
                            value="<?php if(isset($_SESSION['attempted-username'])) {
                                    echo $_SESSION['attempted-username'];
                                    unset($_SESSION['attempted-username']);
                                } else {
                                    echo '';
                            }?>"
                    >

                    <label id="password-label" for="password-input"
                    ><?php if(isset($_SESSION['error-message'])) {
                            if($_SESSION['error-message'] == 'invalidPassword') {
                                unset($_SESSION['error-message']);
                                echo "Invalid password!";
                            }else{
                                echo "password";
                            }
                        }else{
                            echo "password";
                        }?></label>
                    <input
                            type="text"
                            id="password-input"
                            class="text-input-box"
                            name="password-input"
                            placeholder="..."
                            value="<?php if(isset($_SESSION['attempted-password'])) {
                        echo $_SESSION['attempted-password'];
                    } else {
                        echo '';
                    }?>">

                    <input id="submit-btn" class="submit-button" type="submit" value="Submit">
                    <input id="cancel-btn" class="submit-button" type="submit" value="Cancel" formaction="/index.php">
                    <button class="text-button" id="create-account-button" formaction="/create.php">Create&nbspAccount</button>
                </form>
            </div>

        </div>
    </div>
    <div class="page-south"></div>
    <div class="page-east"></div>
    <div class="page-west"></div>

</body>
</html>