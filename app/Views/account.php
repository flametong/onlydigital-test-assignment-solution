<?php require 'parts/header.php' ?>
<?php if (!empty($user)): ?>
    <main>
        <h1>Change your credentials</h1>
        <form action="/account" method="post">
            <?php if (isset($user['error'])) : ?>
                <div>
                    <?php foreach ($user['error'] as $item) : ?>
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
                        placeholder="Change username..."
                        value="<?= $user['username'] ?? "" ?>"
                        required
                />
            </p>
            <p>
                <label for="phone">Phone</label>
                <input
                        type="text"
                        name="phone"
                        id="phone"
                        placeholder="Change phone..."
                        value="<?= $user['phone'] ?? "" ?>"
                        required
                />
            </p>
            <p>
                <label for="email">Email</label>
                <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Change email..."
                        value="<?= $user['email'] ?? "" ?>"
                        required
                />
            </p>
            <p>
                <label for="password">Password</label>
                <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Change password..."
                />
            </p>
            <p>
                <input
                        type="submit"
                        value="Save"
                        name="save"
                />
            </p>
        </form>
    </main>
<?php endif; ?>
<?php require 'parts/footer.php' ?>