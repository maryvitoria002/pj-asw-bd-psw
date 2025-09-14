<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../img/mw..png" type="image/x-icon">
    <title>Cadastro - MusicWave</title>
    <style>
        .cadastro-container {
            max-width: 550px;
            margin: 30px auto;
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .cadastro-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .cadastro-header h1 {
            color: #b45f06;
            margin-bottom: 10px;
            font-size: 2.2em;
        }
        
        /* Progress Bar */
        .progress-container {
            margin-bottom: 30px;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #b45f06, #ff8c00);
            width: 33.33%;
            transition: width 0.3s ease;
            border-radius: 4px;
        }
        
        .steps-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .step-circle.active {
            background: #b45f06;
            color: white;
        }
        
        .step-circle.completed {
            background: #28a745;
            color: white;
        }
        
        .step-label {
            font-size: 12px;
            color: #666;
            text-align: center;
            font-weight: 500;
        }
        
        .step-label.active {
            color: #b45f06;
            font-weight: bold;
        }
        
        /* Form Steps */
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
            max-width: 100%;
            margin: 0 auto;
        }
        
        .form-step.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .step-title {
            color: #b45f06;
            font-size: 1.5em;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            align-items: flex-start;
        }
        
        .form-group {
            margin-bottom: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 16px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            background: #fafafa;
            text-align: left;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #b45f06;
            background: white;
            box-shadow: 0 0 0 3px rgba(180, 95, 6, 0.1);
        }
        
        .form-group.required label::after {
            content: " *";
            color: #e74c3c;
        }
        
        .input-help {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        /* Buttons */
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }
        
        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            max-width: 200px;
        }
        
        .btn-back {
            background: #6c757d;
            color: white;
        }
        
        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .btn-next {
            background: #b45f06;
            color: white;
        }
        
        .btn-next:hover {
            background: #8a4605;
            transform: translateY(-2px);
        }
        
        .btn-submit {
            background: linear-gradient(45deg, #b45f06, #ff8c00);
            color: white;
            width: 100%;
            max-width: none;
        }
        
        .btn-submit:hover {
            background: linear-gradient(45deg, #8a4605, #e67e00);
            transform: translateY(-2px);
        }
        
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: none;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .voltar-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #b45f06;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .voltar-btn:hover {
            background: #8a4605;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
        
        /* Step específico styles */
        .welcome-step {
            text-align: center;
            padding: 20px 0;
        }
        
        .welcome-step i {
            font-size: 4em;
            color: #b45f06;
            margin-bottom: 20px;
        }
        
        .password-strength {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak { background: #e74c3c; }
        .strength-medium { background: #f39c12; }
        .strength-strong { background: #27ae60; }
        
        .validation-message {
            font-size: 12px;
            margin-top: 5px;
            padding: 5px;
            border-radius: 4px;
            display: none;
        }
        
        .validation-error {
            background: #ffe6e6;
            color: #d63384;
            border: 1px solid #f8d7da;
        }
        
        .validation-success {
            background: #e6f7e6;
            color: #198754;
            border: 1px solid #c3e6cb;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .cadastro-container {
                margin: 15px;
                padding: 25px;
                max-width: none;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .button-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn {
                max-width: none;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <a href="../index.php" class="voltar-btn">
        <i class="bi bi-arrow-left"></i>
        Voltar
    </a>

    <div class="cadastro-container">
        <div class="cadastro-header">
            <img src="../img/logomw.png" alt="MusicWave" style="height: 60px; margin-bottom: 10px;">
            <h1>Criar Conta</h1>
            <p>Junte-se à MusicWave em 3 passos simples!</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="steps-indicator">
                <div class="step">
                    <div class="step-circle active" id="step1Circle">1</div>
                    <div class="step-label active" id="step1Label">Dados Pessoais</div>
                </div>
                <div class="step">
                    <div class="step-circle" id="step2Circle">2</div>
                    <div class="step-label" id="step2Label">Contato</div>
                </div>
                <div class="step">
                    <div class="step-circle" id="step3Circle">3</div>
                    <div class="step-label" id="step3Label">Segurança</div>
                </div>
            </div>
        </div>

        <div id="alert" class="alert"></div>

        <form id="cadastroForm">
            <!-- Step 1: Dados Pessoais -->
            <div class="form-step active" id="step1">
                <div class="step-title">
                    <i class="bi bi-person-fill"></i> Dados Pessoais
                </div>
                
                <div class="form-group required">
                    <label for="nome_completo">Nome Completo</label>
                    <input type="text" id="nome_completo" name="nome_completo" required>
                    <div class="input-help">Digite seu nome completo como aparece nos documentos</div>
                </div>

                <div class="form-row">
                    <div class="form-group required">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                        <div class="validation-message" id="cpfValidation"></div>
                    </div>

                    <div class="form-group">
                        <label for="rg">RG</label>
                        <input type="text" id="rg" name="rg" placeholder="Ex: MG1234567">
                        <div class="input-help">Opcional - pode ser preenchido depois</div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Contato -->
            <div class="form-step" id="step2">
                <div class="step-title">
                    <i class="bi bi-envelope-fill"></i> Informações de Contato
                </div>

                <div class="form-row">
                    <div class="form-group required">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                        <div class="input-help">Será usado para login e comunicações</div>
                        <div class="validation-message" id="emailValidation"></div>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000">
                        <div class="input-help">Para contato sobre pedidos e promoções</div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Segurança -->
            <div class="form-step" id="step3">
                <div class="step-title">
                    <i class="bi bi-shield-lock-fill"></i> Segurança da Conta
                </div>

                <div class="form-group required">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                    <div class="password-strength">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <div class="input-help" id="passwordHelp">Mínimo 6 caracteres</div>
                </div>

                <div class="form-group required">
                    <label for="confirmar_senha">Confirmar Senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required>
                    <div class="validation-message" id="confirmPasswordValidation"></div>
                </div>

                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 25px; text-align: center;">
                    <h4 style="color: #b45f06; margin-bottom: 15px;"><i class="bi bi-check-circle"></i> Resumo dos Dados</h4>
                    <div id="summaryContent" style="text-align: left; max-width: 400px; margin: 0 auto;"></div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="button-group">
                <button type="button" class="btn btn-back" id="btnBack" style="display: none;">
                    <i class="bi bi-arrow-left"></i> Voltar
                </button>
                <button type="button" class="btn btn-next" id="btnNext">
                    Próximo <i class="bi bi-arrow-right"></i>
                </button>
                <button type="submit" class="btn btn-submit" id="btnSubmit" style="display: none;">
                    <i class="bi bi-person-plus"></i> Criar Conta
                </button>
            </div>
        </form>

        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
            <p>Já tem uma conta? <a href="login-usuario.php" style="color: #b45f06; text-decoration: none; font-weight: 600;">Fazer login</a></p>
        </div>
    </div>

    <script src="cadastro-steps.js"></script>
</body>
</html>
