const fs = require('fs');
const path = require('path');
const cssDir = path.join(__dirname, 'resources/css');
const files = fs.readdirSync(cssDir).filter(f => f.endsWith('.css'));

for (const file of files) {
    if (file === 'variables.css') continue;
    const filePath = path.join(cssDir, file);
    let content = fs.readFileSync(filePath, 'utf8');

    content = content.replace(/#4e488d/gi, 'var(--primary)');
    content = content.replace(/#3b366e/gi, 'var(--accent-d)');
    content = content.replace(/#ece8f9/gi, 'var(--primary-bg)');
    content = content.replace(/#e3e0fb/gi, 'var(--primary-bg)');
    content = content.replace(/#cebcf5/gi, 'var(--primary-bdr)');

    fs.writeFileSync(filePath, content);
}
console.log('Cleaned up hardcoded purple colors in CSS');
