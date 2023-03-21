<main class="home">
    <h2>Log in</h2>

    <form action="/user/login" method="post" style="padding: 40px">
        <label>Enter Email</label>
        <input type="email" name="email" />

        <label>Enter Password</label>
        <input type="password" name="password" />

        <input type="submit" name="submit" value="Log In" />
    </form>
</main>
<p><?=nl2br($response)?></p>