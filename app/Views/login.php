<?php require 'parts/header.php' ?>
    <main>
        <h1>Login</h1>

        <?php $message ??= ""; ?>

        <?= $message ?>
        
        <form action="/login" method="post">

            <?php $login ??= ""; ?>

            <p>
                <label for="login">Login</label>
                <input
                        type="text"
                        name="login"
                        id="login"
                        placeholder="Enter phone or email..."
                        value="<?= $login ?>"
                        required
                />
            </p>
            <p>
                <label for="password">Password</label>
                <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Enter password..."
                        required
                />
            </p>
            <div
                    id="captcha-container"
                    class="smart-captcha"
                    data-sitekey="ysc1_tc5zXI9f5jvAxQWwboO4IaaQiuYnZfV1osqJDW3s6e4d3670"
            >
                <input
                        type="hidden"
                        name="smart-token"
                        value="<token>"
                />
            </div>
            <p>
                <input
                        type="submit"
                        value="Login"
                        name="loginInput"
                />
            </p>
        </form>
    </main>
<?php require 'parts/footer.php' ?>