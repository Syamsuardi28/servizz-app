const fs = require('fs');
const path = require('path');

const bladePath = path.join(__dirname, 'resources/views/layouts/app.blade.php');
let content = fs.readFileSync(bladePath, 'utf8');

const replacements = [
    { from: /#d6ccff/gi, to: 'var(--primary-bg)' },
    { from: /#b8acf0/gi, to: 'var(--primary-bdr)' },
    { from: /#4e488d/gi, to: 'var(--primary)' },
    { from: /#fef2f2/gi, to: 'var(--err-bg)' },
    { from: /#991b1b/gi, to: 'var(--err)' },
    { from: /#ecfdf5/gi, to: 'var(--ok-bg)' },
    { from: /#166534/gi, to: 'var(--ok)' },
    { from: /#ef4444/gi, to: 'var(--err)' },
    { from: /#3b82f6/gi, to: 'var(--info)' },
    { from: /#1e293b/gi, to: 'var(--txt)' },
    { from: /#f1f5f9/gi, to: 'var(--border)' },
    { from: /#64748b/gi, to: 'var(--muted)' },
    { from: /#cbd5e1/gi, to: 'var(--muted)' }
];

for (const r of replacements) {
    content = content.replace(r.from, r.to);
}

fs.writeFileSync(bladePath, content);
console.log('App blade inline replaced');
