<main class="login-page">
    <section class="login-card">
        <div class="login-brand"><i class="fas fa-shield-halved"></i><span>SIMU</span></div>
        <h1>Iniciar sesión</h1>
        <p class="text-muted">Accede al sistema según los permisos de tu cuenta.</p>
        <form method="post" action="index.php?pg=login">
            <?= csrf_field() ?><input type="hidden" name="action" value="login">
            <label for="correo">Correo electrónico</label>
            <input id="correo" name="correo" type="email" required autocomplete="username">
            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
            <button class="btn btn-primary w-100 mt-3" type="submit">Entrar</button>
        </form>
    </section>
</main>
