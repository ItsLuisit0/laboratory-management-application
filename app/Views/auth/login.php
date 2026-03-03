<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — LabControl | TECNM Teziutlán</title>
    <meta name="description" content="Sistema de Gestión de Laboratorios — Tecnológico Nacional de México, Campus Teziutlán">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header mb-4 text-center">
                    <img src="<?= base_url('assets/images/logoLOGINTECNM.png') ?>" alt="Logo TECNM" style="max-width: 100%; height: auto;">
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mb-3 py-2 px-3" role="alert" style="font-size: 0.85rem; border-radius: 4px;">
                    <?= session()->getFlashdata('error') ?>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success mb-3 py-2 px-3" role="alert" style="font-size: 0.85rem; border-radius: 4px;">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <?php endif; ?>

                <form action="/auth/authenticate" method="post" class="login-form">
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" id="correo" name="correo"
                               placeholder="23te0055" required autofocus
                               value="<?= old('correo') ?>"
                               style="border-radius: 8px; border: 1px solid #ced4da; padding: 8px 12px; font-size: 0.85rem; background-color: #ffffff;">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control form-control-sm" id="password" name="password"
                               placeholder="••••••••••••" required
                               style="border-radius: 8px; border: 1px solid #ced4da; padding: 8px 12px; font-size: 0.85rem; background-color: #e8f0fe;">
                    </div>
                    
                    <div class="mb-3 text-start">
                        <button type="submit" class="btn btn-primary px-4 py-1" style="background-color: #0f6cb6; border-color: #0f6cb6; border-radius: 8px; font-weight: normal; font-size: 0.85rem;">
                            Acceder
                        </button>
                    </div>

                    <div class="mb-4 text-start">
                        <a href="#" style="font-size: 0.85rem; color: #0f6cb6; text-decoration: none;">¿Olvidó su contraseña?</a>
                    </div>
                </form>

                <div class="pt-4 mt-3 border-top text-start">
                    <h6 style="font-size: 0.95rem; font-weight: 600; color: #212529; margin-bottom: 12px;">Algunos cursos permiten el acceso de invitados</h6>
                    <a href="/calendario" class="btn btn-secondary btn-sm" style="background-color: #ced4da; color: #495057; border: none; border-radius: 4px; font-size: 0.85rem; padding: 6px 14px; text-decoration: none; display: inline-block;">Entrar como persona invitada</a>
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
