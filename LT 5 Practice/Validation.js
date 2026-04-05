function analyzeText() {
    const text = document.getElementById('textInput').value;
    const charCountSpan = document.getElementById('charCount');
    const wordCountSpan = document.getElementById('wordCount');
    const reversedOutputDiv = document.getElementById('reversedOutput');
    
    if (text.trim() === '') {
        charCountSpan.textContent = '0';
        wordCountSpan.textContent = '0';
        reversedOutputDiv.textContent = "No text";
        return;
    }
    const charCount = text.length;
    const wordCount = text.trim().split(/\s+/).length;
    const reversedText = text.split('').reverse().join('');

    charCountSpan.textContent = charCount;
    wordCountSpan.textContent = wordCount;
    reversedOutputDiv.textContent = reversedText;
}