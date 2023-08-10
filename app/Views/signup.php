<?php require 'parts/header.php' ?>
    <main>
        <h1>Sign Up</h1>
        <form action="/signup" method="post">
            <?php if (isset($data['error'])) : ?>
                <div>
                    <?php foreach ($data['error'] as $item) : ?>
                        <p>
                            Error: <?= $item ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <p>
                <label for="username">Username</label>
                <input
                        type="text"
                        name="username"
                        id="username"
                        placeholder="Enter username..."
                        value="<?= $data['username'] ?? "" ?>"
                        required
                />
            </p>
            <p>
                <label for="phone">Phone</label>
                <input
                        type="text"
                        name="phone"
                        id="phone"
                        placeholder="+7 (999) 999-99-99"
                        value="<?= $data['phone'] ?? "" ?>"
                        required
                />
            </p>
            <p>
                <label for="email">Email</label>
                <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="ivan@example.com"
                        value="<?= $data['email'] ?? "" ?>"
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
            <p>
                <label for="password_duplicate">Repeat password</label>
                <input
                        type="password"
                        name="password_duplicate"
                        id="password_duplicate"
                        placeholder="Repeat password..."
                        required
                />
            </p>
            <p>
                <input
                        type="submit"
                        value="Sign Up"
                        name="signup"
                />
            </p>
        </form>
    </main>
<?php require 'parts/footer.php' ?>