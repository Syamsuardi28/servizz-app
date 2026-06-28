const fs = require('fs');
const path = require('path');

const mappings = [
    { blade: 'layouts/app.blade.php', css: 'layout.css' },
    { blade: 'dashboard/index.blade.php', css: 'dashboard.css' },
    { blade: 'help/index.blade.php', css: 'help.css' },
    { blade: 'profile/index.blade.php', css: 'profile.css' },
    { blade: 'services/index.blade.php', css: 'services.css' },
    { blade: 'settings/index.blade.php', css: 'settings.css' },
    { blade: 'settings/layout.blade.php', css: 'settings.css' },
    { blade: 'settings/notifications.blade.php', css: 'settings.css' },
    { blade: 'settings/verification.blade.php', css: 'settings.css' },
    { blade: 'technicians/show.blade.php', css: 'technicians.css' },
    { blade: 'users/index.blade.php', css: 'users.css' },
    { blade: 'users/show.blade.php', css: 'users.css' }
];

const cssDir = path.join(__dirname, 'resources/css');
const viewsDir = path.join(__dirname, 'resources/views');

for (const map of mappings) {
    const bladePath = path.join(viewsDir, map.blade);
    if (!fs.existsSync(bladePath)) continue;

    let content = fs.readFileSync(bladePath, 'utf8');
    const styleRegex = /<style>([\s\S]*?)<\/style>/g;
    let match;
    let extractedStyles = '';

    while ((match = styleRegex.exec(content)) !== null) {
        extractedStyles += match[1] + '\n';
    }

    if (extractedStyles) {
        content = content.replace(/<style>[\s\S]*?<\/style>\s*/g, '');
        
        if (map.blade !== 'layouts/app.blade.php' && map.blade !== 'settings/layout.blade.php' && !content.includes(map.css)) {
            const pushStr = "\n@push('styles')\n    @vite('resources/css/" + map.css + "')\n@endpush\n";
            if (content.includes("@section('content')")) {
                content = content.replace("@section('content')", pushStr + "\n@section('content')");
            } else if (content.includes("@section('settings_content')")) {
                content = content.replace("@section('settings_content')", pushStr + "\n@section('settings_content')");
            } else {
                content = pushStr + content;
            }
        }
        
        fs.writeFileSync(bladePath, content);
        
        extractedStyles = extractedStyles.replace(/#d6ccff/gi, 'var(--primary-bg)');
        extractedStyles = extractedStyles.replace(/#b8acf0/gi, 'var(--primary-bdr)');
        extractedStyles = extractedStyles.replace(/#4e488d/gi, 'var(--primary)');
        extractedStyles = extractedStyles.replace(/#185FA5/gi, 'var(--primary)');
        extractedStyles = extractedStyles.replace(/#D85A30/gi, 'var(--accent)');

        const cssPath = path.join(cssDir, map.css);
        if (fs.existsSync(cssPath)) {
            fs.appendFileSync(cssPath, '\n/* Extracted from ' + map.blade + ' */\n' + extractedStyles);
        } else {
            fs.writeFileSync(cssPath, '/* Extracted from ' + map.blade + ' */\n' + extractedStyles);
        }
    }
}
console.log('Done');
