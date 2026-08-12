const fs = require('fs');
const line = fs.readFileSync('sidebar_json.txt', 'utf16le'); // PowerShell Out-File uses UTF-16LE by default
try {
    const entry = JSON.parse(line.trim());
    if (entry.content) {
        let lines = entry.content.split('\n');
        let originalContent = [];
        let isCode = false;
        for (const l of lines) {
            const match = l.match(/^\d+:\s(.*)/);
            if (match) {
                originalContent.push(match[1]);
                isCode = true;
            } else if (isCode && !l.includes('The above content shows the entire') && !l.includes('The following code has been modified')) {
                // ignore
            }
        }
        if (originalContent.length > 0) {
            fs.writeFileSync('c:\\xampp\\htdocs\\virratpos\\resources\\views\\partials\\ui\\sidebar.blade.php', originalContent.join('\n') + '\n', 'utf8');
            console.log('Restored sidebar.blade.php');
        } else {
            console.log('Could not find code lines in content.');
        }
    } else {
        console.log('No content in JSON entry.');
    }
} catch(e) {
    console.error('Error:', e);
}
