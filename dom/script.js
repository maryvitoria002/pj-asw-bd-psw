// Definindo as frequências para cada corda dos instrumentos
const instrumentNotes = {
    "violin": {
        "G": 196,    // Sol (G3)
        "D": 293.66, // Ré (D4)
        "A": 440,    // Lá (A4)
        "E": 659.25  // Mi (E5)
    },
    "viola": {
        "C": 130.81, // Do (C3)
        "G": 196,    // Sol (G3)
        "D": 293.66, // Ré (D4)
        "A": 440     // Lá (A4)
    },
    "cello": {
        "C": 65.41,  // Do (C2)
        "G": 98,     // Sol (G2)
        "D": 146.83, // Ré (D3)
        "A": 220     // Lá (A3)
    }
};

// Função para tocar a nota de acordo com o instrumento e a nota selecionada
function playNote(note, instrument) {
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    const oscillator = audioContext.createOscillator();
    
    // Verificar se a nota é válida para o instrumento e se existe
    if (instrumentNotes[instrument] && instrumentNotes[instrument][note]) {
        const frequency = instrumentNotes[instrument][note];
        
        // Definir a frequência da nota
        oscillator.type = "sine"; // Tipo de onda (senoidal para uma nota mais pura)
        oscillator.frequency.setValueAtTime(frequency, audioContext.currentTime);
        
        // Conectar ao destino (alto-falante)
        oscillator.connect(audioContext.destination);
        
        // Iniciar o som
        oscillator.start();
        
        // Parar o som após 2 segundos
        oscillator.stop(audioContext.currentTime + 2);
    } else {
        console.error(`Nota ${note} não encontrada para o instrumento ${instrument}`);
    }
}
