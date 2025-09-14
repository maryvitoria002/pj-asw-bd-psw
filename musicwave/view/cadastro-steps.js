class CadastroSteps {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 3;
        this.formData = {};
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.setupMasks();
        this.setupValidation();
    }
    
    setupEventListeners() {
        // Botões de navegação
        document.getElementById('btnNext').addEventListener('click', () => this.nextStep());
        document.getElementById('btnBack').addEventListener('click', () => this.prevStep());
        
        // Formulário
        document.getElementById('cadastroForm').addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Validação em tempo real
        document.getElementById('cpf').addEventListener('blur', () => this.validateCPF());
        document.getElementById('email').addEventListener('blur', () => this.validateEmail());
        document.getElementById('senha').addEventListener('input', () => this.checkPasswordStrength());
        document.getElementById('confirmar_senha').addEventListener('input', () => this.validatePasswordMatch());
    }
    
    setupMasks() {
        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });

        // Máscara para telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{4,5})(\d{4})$/, '$1-$2');
            e.target.value = value;
        });
    }
    
    setupValidation() {
        // Validação ao pressionar Enter
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && this.currentStep < this.totalSteps) {
                e.preventDefault();
                this.nextStep();
            }
        });
    }
    
    nextStep() {
        if (!this.validateCurrentStep()) {
            return;
        }
        
        this.saveCurrentStepData();
        
        if (this.currentStep < this.totalSteps) {
            this.currentStep++;
            this.updateUI();
            
            if (this.currentStep === this.totalSteps) {
                this.showSummary();
            }
        }
    }
    
    prevStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.updateUI();
        }
    }
    
    validateCurrentStep() {
        const currentStepElement = document.getElementById(`step${this.currentStep}`);
        const requiredFields = currentStepElement.querySelectorAll('input[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                this.showFieldError(field, 'Este campo é obrigatório');
                isValid = false;
            } else {
                this.clearFieldError(field);
            }
        });
        
        // Validações específicas por step
        if (this.currentStep === 1) {
            isValid = this.validateStep1() && isValid;
        } else if (this.currentStep === 2) {
            isValid = this.validateStep2() && isValid;
        } else if (this.currentStep === 3) {
            isValid = this.validateStep3() && isValid;
        }
        
        return isValid;
    }
    
    validateStep1() {
        const cpf = document.getElementById('cpf').value;
        
        if (cpf && !this.isValidCPF(cpf)) {
            this.showValidationMessage('cpfValidation', 'CPF inválido', 'error');
            return false;
        } else if (cpf) {
            this.showValidationMessage('cpfValidation', 'CPF válido', 'success');
        }
        
        return true;
    }
    
    validateStep2() {
        const email = document.getElementById('email').value;
        
        if (email && !this.isValidEmail(email)) {
            this.showValidationMessage('emailValidation', 'Email inválido', 'error');
            return false;
        } else if (email) {
            this.showValidationMessage('emailValidation', 'Email válido', 'success');
        }
        
        return true;
    }
    
    validateStep3() {
        const senha = document.getElementById('senha').value;
        const confirmarSenha = document.getElementById('confirmar_senha').value;
        
        if (senha.length < 6) {
            this.showFieldError(document.getElementById('senha'), 'Senha deve ter pelo menos 6 caracteres');
            return false;
        }
        
        if (senha !== confirmarSenha) {
            this.showValidationMessage('confirmPasswordValidation', 'As senhas não coincidem', 'error');
            return false;
        } else if (confirmarSenha) {
            this.showValidationMessage('confirmPasswordValidation', 'Senhas coincidem', 'success');
        }
        
        return true;
    }
    
    saveCurrentStepData() {
        const currentStepElement = document.getElementById(`step${this.currentStep}`);
        const inputs = currentStepElement.querySelectorAll('input');
        
        inputs.forEach(input => {
            this.formData[input.name] = input.value;
        });
    }
    
    updateUI() {
        // Atualizar steps
        for (let i = 1; i <= this.totalSteps; i++) {
            const stepElement = document.getElementById(`step${i}`);
            const circleElement = document.getElementById(`step${i}Circle`);
            const labelElement = document.getElementById(`step${i}Label`);
            
            if (i === this.currentStep) {
                stepElement.classList.add('active');
                circleElement.classList.add('active');
                circleElement.classList.remove('completed');
                labelElement.classList.add('active');
            } else if (i < this.currentStep) {
                stepElement.classList.remove('active');
                circleElement.classList.remove('active');
                circleElement.classList.add('completed');
                labelElement.classList.remove('active');
            } else {
                stepElement.classList.remove('active');
                circleElement.classList.remove('active', 'completed');
                labelElement.classList.remove('active');
            }
        }
        
        // Atualizar progress bar
        const progressPercent = ((this.currentStep - 1) / (this.totalSteps - 1)) * 100;
        document.getElementById('progressFill').style.width = `${progressPercent}%`;
        
        // Atualizar botões
        const btnBack = document.getElementById('btnBack');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');
        
        btnBack.style.display = this.currentStep > 1 ? 'block' : 'none';
        
        if (this.currentStep < this.totalSteps) {
            btnNext.style.display = 'block';
            btnSubmit.style.display = 'none';
        } else {
            btnNext.style.display = 'none';
            btnSubmit.style.display = 'block';
        }
    }
    
    showSummary() {
        const summaryContent = document.getElementById('summaryContent');
        const nome = document.getElementById('nome_completo').value;
        const cpf = document.getElementById('cpf').value;
        const email = document.getElementById('email').value;
        const telefone = document.getElementById('telefone').value || 'Não informado';
        
        summaryContent.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr; gap: 12px; font-size: 14px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e0e0e0;">
                    <strong>Nome:</strong> <span>${nome}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e0e0e0;">
                    <strong>CPF:</strong> <span>${cpf}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e0e0e0;">
                    <strong>Email:</strong> <span>${email}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                    <strong>Telefone:</strong> <span>${telefone}</span>
                </div>
            </div>
        `;
    }
    
    validateCPF() {
        const cpf = document.getElementById('cpf').value;
        if (cpf && this.isValidCPF(cpf)) {
            this.showValidationMessage('cpfValidation', 'CPF válido', 'success');
        } else if (cpf) {
            this.showValidationMessage('cpfValidation', 'CPF inválido', 'error');
        }
    }
    
    validateEmail() {
        const email = document.getElementById('email').value;
        if (email && this.isValidEmail(email)) {
            this.showValidationMessage('emailValidation', 'Email válido', 'success');
        } else if (email) {
            this.showValidationMessage('emailValidation', 'Email inválido', 'error');
        }
    }
    
    checkPasswordStrength() {
        const senha = document.getElementById('senha').value;
        const strengthFill = document.getElementById('strengthFill');
        const passwordHelp = document.getElementById('passwordHelp');
        
        let strength = 0;
        let message = 'Muito fraca';
        let className = 'strength-weak';
        
        if (senha.length >= 6) strength += 25;
        if (senha.length >= 8) strength += 25;
        if (/[A-Z]/.test(senha)) strength += 25;
        if (/[0-9]/.test(senha)) strength += 25;
        
        if (strength >= 75) {
            message = 'Forte';
            className = 'strength-strong';
        } else if (strength >= 50) {
            message = 'Média';
            className = 'strength-medium';
        }
        
        strengthFill.style.width = `${strength}%`;
        strengthFill.className = `strength-fill ${className}`;
        passwordHelp.textContent = `Força da senha: ${message}`;
    }
    
    validatePasswordMatch() {
        const senha = document.getElementById('senha').value;
        const confirmarSenha = document.getElementById('confirmar_senha').value;
        
        if (confirmarSenha) {
            if (senha === confirmarSenha) {
                this.showValidationMessage('confirmPasswordValidation', 'Senhas coincidem', 'success');
            } else {
                this.showValidationMessage('confirmPasswordValidation', 'As senhas não coincidem', 'error');
            }
        }
    }
    
    showValidationMessage(elementId, message, type) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = message;
            element.className = `validation-message validation-${type}`;
            element.style.display = 'block';
        }
    }
    
    showFieldError(field, message) {
        field.style.borderColor = '#e74c3c';
        // Criar ou atualizar mensagem de erro
        let errorElement = field.parentNode.querySelector('.field-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'field-error';
            errorElement.style.cssText = 'color: #e74c3c; font-size: 12px; margin-top: 5px;';
            field.parentNode.appendChild(errorElement);
        }
        errorElement.textContent = message;
    }
    
    clearFieldError(field) {
        field.style.borderColor = '#e0e0e0';
        const errorElement = field.parentNode.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
    }
    
    isValidCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
            return false;
        }
        
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        
        let remainder = 11 - (sum % 11);
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(9))) return false;
        
        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        
        remainder = 11 - (sum % 11);
        if (remainder === 10 || remainder === 11) remainder = 0;
        
        return remainder === parseInt(cpf.charAt(10));
    }
    
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        if (!this.validateCurrentStep()) {
            return;
        }
        
        const btn = document.getElementById('btnSubmit');
        const alert = document.getElementById('alert');
        
        // Desabilitar botão e mostrar loading
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Criando conta...';
        this.hideAlert();
        
        // Coletar dados do formulário
        const formData = new FormData(document.getElementById('cadastroForm'));
        formData.append('acao', 'cadastrar');
        
        try {
            const response = await fetch('../../APP/controller/CadastroController.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.sucesso) {
                this.showAlert(data.mensagem, 'success');
                
                // Animação de sucesso
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Conta criada!';
                btn.style.background = '#28a745';
                
                // Redirecionar para login após 3 segundos
                setTimeout(() => {
                    window.location.href = 'login-usuario.php';
                }, 3000);
            } else {
                this.showAlert(data.mensagem, 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-person-plus"></i> Criar Conta';
            }
        } catch (error) {
            console.error('Erro:', error);
            this.showAlert('Erro de comunicação com o servidor', 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-person-plus"></i> Criar Conta';
        }
    }
    
    showAlert(message, type) {
        const alert = document.getElementById('alert');
        alert.textContent = message;
        alert.className = `alert alert-${type}`;
        alert.style.display = 'block';
        
        // Scroll para o topo
        alert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    hideAlert() {
        const alert = document.getElementById('alert');
        alert.style.display = 'none';
    }
}

// Inicializar quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
    new CadastroSteps();
});
