<style>
    
    .login-container {
        min-height: 75vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-card {
        max-width: 420px;
        width: 100%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(138, 43, 226, 0.3);
        border-radius: 16px;
        padding: 40px 30px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        color: #010101;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header h2 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1.8rem;
        margin-bottom: 8px;
        background: purple;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .login-header p {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
    }

    .alert-error {
        background: rgba(255, 77, 77, 0.15);
        border: 1px solid rgba(255, 77, 77, 0.4);
        color: #ff4d4d;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 0.88rem;
        margin-bottom: 20px;
        text-align: center;
    }

    .grupo-login {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .grupo-login label {
        font-size: 0.85rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .grupo-login input {
        width: 100%;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.3s ease;
    }

    .grupo-login input:focus {
        border-color: #a855f7;
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 12px rgba(168, 85, 247, 0.3);
    }

    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #8a2be2 0%, #a855f7 100%);
        border: none;
        border-radius: 8px;
        color: #fff;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-top: 10px;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(138, 43, 226, 0.4);
    }

    .btn-login:active {
        transform: translateY(0);
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>Acceso</h2>
            <p>Ingresa tus credenciales para administrar el portafolio</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert-error">
                <?php if ($_GET['error'] === 'vacios'): ?>
                    Por favor, completa todos los campos.
                <?php else: ?>
                    Usuario o contraseña incorrectos.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=login_post" method="POST">
            <div class="grupo-login">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" placeholder="Usuario" required autocomplete="off">
            </div>

            <div class="grupo-login">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">Ingresar</button>
        </form>
    </div>
</div>