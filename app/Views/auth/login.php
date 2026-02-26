<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — LabControl | TECNM Teziutlán</title>
    <meta name="description" content="Sistema de Gestión de Laboratorios — Tecnológico Nacional de México, Campus Teziutlán">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-logo">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h1>LabControl</h1>
                    <p>Sistema de Gestión de Laboratorios</p>
                    <p class="inst-name">Tecnológico Nacional de México — Campus Teziutlán</p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
                <?php endif; ?>

                <form action="/auth/authenticate" method="post" class="login-form">
                    <div class="mb-3">
                        <label for="correo" class="form-label fw-semibold" style="color:#475569">
                            <i class="bi bi-envelope me-1"></i> Correo Institucional
                        </label>
                        <div class="position-relative">
                            <span class="input-icon"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control" id="correo" name="correo"
                                   placeholder="usuario@teziutlan.tecnm.mx" required autofocus
                                   value="<?= old('correo') ?>"
                                   style="padding-left:44px">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold" style="color:#475569">
                            <i class="bi bi-shield-lock me-1"></i> Contraseña
                        </label>
                        <div class="position-relative">
                            <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="••••••••" required
                                   style="padding-left:44px">
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted me-2 p-0"
                                    onclick="togglePass()" tabindex="-1" style="text-decoration:none">
                                <i class="bi bi-eye" id="passToggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login text-white w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="/calendario" class="text-muted text-decoration-none" style="font-size:0.83rem">
                        <i class="bi bi-calendar3 me-1"></i> Ver calendario público de laboratorios
                    </a>
                </div>

                <div class="login-footer">
                    &copy; <?= date('Y') ?> LabControl — TECNM Campus Teziutlán, Puebla
                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePass() {
        const p = document.getElementById('password');
        const i = document.getElementById('passToggleIcon');
        if (p.type === 'password') { p.type = 'text'; i.className = 'bi bi-eye-slash'; }
        else { p.type = 'password'; i.className = 'bi bi-eye'; }
    }
    </script>
</body>
</html>
