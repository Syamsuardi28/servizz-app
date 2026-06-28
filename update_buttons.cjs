const fs = require('fs');
const path = require('path');

const cssDir = path.join(__dirname, 'resources/css');

const filesToProcess = ['app.css', 'servizz.css', 'auth.css', 'settings.css'];

for (const file of filesToProcess) {
    const filePath = path.join(cssDir, file);
    if (fs.existsSync(filePath)) {
        let content = fs.readFileSync(filePath, 'utf8');

        // Regex to match specific button classes and replace primary with accent
        content = content.replace(/\.(svz-btn-primary|btn-primary|btn-submit|btn-save)([\s\S]*?)\}/g, (match, className, body) => {
            let newBody = body.replace(/--primary-d/g, '--accent-d').replace(/--primary(?!-)/g, '--accent');
            return `.${className}${newBody}}`;
        });
        
        content = content.replace(/\.(svz-btn-primary|btn-primary|btn-submit|btn-save):hover([\s\S]*?)\}/g, (match, className, body) => {
            let newBody = body.replace(/--primary-d/g, '--accent-d').replace(/--primary(?!-)/g, '--accent');
            return `.${className}:hover${newBody}}`;
        });

        // Also change --primary to --accent in btn-outline-primary
        content = content.replace(/\.btn-outline-primary([\s\S]*?)\}/g, (match, body) => {
            let newBody = body.replace(/--primary-d/g, '--accent-d').replace(/--primary(?!-)/g, '--accent');
            return `.btn-outline-primary${newBody}}`;
        });

        fs.writeFileSync(filePath, content);
        console.log('Processed ' + file);
    }
}
