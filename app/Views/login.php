<?php require 'parts/header.php' ?>
    <main>
        <h1>Login</h1>
        <?php $message = $message ?? ""; ?>
        <?= $message ?>
        <form action="/login" method="post">

            <?php $login = $login ?? ""; ?>

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
                    data-sitekey="ysc1_L9HtmsH0oTwvGiC7bqBkszhBUWoPJ26wNSku4xvubda79c64"
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