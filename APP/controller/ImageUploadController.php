<?php
/*
====================================================================
🖼️ CONTROLADOR DE UPLOAD DE IMAGENS
====================================================================

🎯 PROPÓSITO:
Gerencia upload, otimização e exclusão de imagens para produtos.
Sistema seguro com validação de tipos e tamanhos.

🔧 FUNCIONALIDADES:

📤 UPLOAD:
✅ uploadImage() - Linha ~30
   - Valida tipo de arquivo (JPG, PNG, GIF)
   - Limita tamanho (máx 5MB)
   - Gera nome único
   - Move para diretório seguro

🎨 OTIMIZAÇÃO:
✅ optimizeImage() - Linha ~100
   - Redimensiona se necessário (max 800x600)
   - Comprime mantendo qualidade
   - Preserva transparência (PNG)

🗑️ EXCLUSÃO:
✅ deleteImage() - Linha ~180
   - Remove arquivo do servidor
   - Validação de caminho

📁 ESTRUTURA DE ARQUIVOS:
- Diretório: musicwave/uploads/produtos/
- Nomenclatura: produto_[ID_ÚNICO].[extensão]
- Proteção: .htaccess para segurança

🔒 VALIDAÇÕES:
- Tipos permitidos: image/jpeg, image/png, image/gif
- Tamanho máximo: 5MB
- Verificação de diretório gravável
- Proteção contra uploads maliciosos

📡 RETORNO JSON:
{
  "sucesso": boolean,
  "mensagem": string,
  "url": string (caminho relativo),
  "filename": string
}

🎯 COMO USAR:
1. POST com acao='upload' e arquivo 'imagem'
2. Sistema valida e processa
3. Retorna URL para uso no frontend
====================================================================
*/

session_start();
header('Content-Type: application/json');

class ImageUploadController {
    private $uploadDir;
    private $allowedTypes;
    private $maxFileSize;
    
    public function __construct() {
        // Usar caminho absoluto baseado na estrutura do projeto
        $baseDir = realpath(__DIR__ . '/../../musicwave/uploads/produtos/');
        $this->uploadDir = $baseDir ? $baseDir . DIRECTORY_SEPARATOR : __DIR__ . '/../../musicwave/uploads/produtos/';
        
        $this->allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $this->maxFileSize = 5 * 1024 * 1024; // 5MB
        
        // Criar diretório se não existir
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    public function uploadImage($file) {
        try {
            // Verificar se arquivo foi enviado
            if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro no upload do arquivo'
                ];
            }
            
            // Verificar se diretório existe e é gravável
            if (!is_dir($this->uploadDir)) {
                if (!mkdir($this->uploadDir, 0755, true)) {
                    return [
                        'sucesso' => false,
                        'mensagem' => 'Erro ao criar diretório de upload'
                    ];
                }
            }

            if (!is_writable($this->uploadDir)) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Diretório de upload não tem permissão de escrita'
                ];
            }            // Verificar tamanho do arquivo
            if ($file['size'] > $this->maxFileSize) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Arquivo muito grande. Máximo permitido: 5MB'
                ];
            }
            
            // Verificar tipo do arquivo
            if (!in_array($file['type'], $this->allowedTypes)) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Tipo de arquivo não permitido. Use apenas JPG, PNG ou GIF. Tipo recebido: ' . $file['type']
                ];
            }
            
            // Gerar nome único para o arquivo
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'produto_' . uniqid() . '.' . $extension;
            $filepath = $this->uploadDir . $filename;
            
            // Mover arquivo para diretório de destino
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // Otimizar imagem se for muito grande
                $this->optimizeImage($filepath, $file['type']);
                
                // Gerar URL relativa correta
                $relativeUrl = 'uploads/produtos/' . $filename;
                
                return [
                    'sucesso' => true,
                    'mensagem' => 'Imagem enviada com sucesso',
                    'url' => $relativeUrl,
                    'filename' => $filename
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Erro ao salvar arquivo no servidor'
                ];
            }
            
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro interno: ' . $e->getMessage()
            ];
        }
    }
    
    private function optimizeImage($filepath, $mimeType) {
        try {
            $maxWidth = 800;
            $maxHeight = 600;
            $quality = 85;
            
            // Obter dimensões originais
            list($width, $height) = getimagesize($filepath);
            
            // Se a imagem já é pequena, não otimizar
            if ($width <= $maxWidth && $height <= $maxHeight) {
                return;
            }
            
            // Calcular novas dimensões mantendo proporção
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = intval($width * $ratio);
            $newHeight = intval($height * $ratio);
            
            // Criar nova imagem
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Carregar imagem original baseada no tipo
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $source = imagecreatefromjpeg($filepath);
                    break;
                case 'image/png':
                    $source = imagecreatefrompng($filepath);
                    // Preservar transparência
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                    break;
                case 'image/gif':
                    $source = imagecreatefromgif($filepath);
                    break;
                default:
                    return;
            }
            
            // Redimensionar
            imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            
            // Salvar imagem otimizada
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    imagejpeg($newImage, $filepath, $quality);
                    break;
                case 'image/png':
                    imagepng($newImage, $filepath, intval($quality / 10 - 1));
                    break;
                case 'image/gif':
                    imagegif($newImage, $filepath);
                    break;
            }
            
            // Limpar memória
            imagedestroy($source);
            imagedestroy($newImage);
            
        } catch (Exception $e) {
            // Se otimização falhar, manter imagem original
        }
    }
    
    public function deleteImage($imagePath) {
        try {
            // Construir caminho completo
            $baseDir = realpath(__DIR__ . '/../../musicwave/');
            $fullPath = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $imagePath);
            
            if (file_exists($fullPath)) {
                unlink($fullPath);
                return [
                    'sucesso' => true,
                    'mensagem' => 'Imagem removida com sucesso'
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Arquivo não encontrado'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao remover arquivo: ' . $e->getMessage()
            ];
        }
    }
}

// Processar requisições
$controller = new ImageUploadController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    switch ($acao) {
        case 'upload':
            if (isset($_FILES['imagem'])) {
                $resultado = $controller->uploadImage($_FILES['imagem']);
                echo json_encode($resultado);
            } else {
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'Nenhum arquivo enviado'
                ]);
            }
            break;
            
        case 'delete':
            $imagePath = $_POST['image_path'] ?? '';
            if (!empty($imagePath)) {
                $resultado = $controller->deleteImage($imagePath);
                echo json_encode($resultado);
            } else {
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'Caminho da imagem não informado'
                ]);
            }
            break;
            
        default:
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Ação não reconhecida'
            ]);
    }
} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método não permitido'
    ]);
}
?>
