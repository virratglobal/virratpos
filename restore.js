const fs = require('fs');
const readline = require('readline');
const path = require('path');

const logPath = path.join(process.env.USERPROFILE, '.gemini/antigravity-ide/brain/3011e5ac-3dc5-4d7f-b0a1-ab16a411bbe8/.system_generated/logs/transcript_full.jsonl');

const filesToRestore = [
    'c:\\xampp\\htdocs\\virratpos\\resources\\views\\partials\\ui\\sidebar.blade.php',
    'c:\\xampp\\htdocs\\virratpos\\resources\\views\\partials\\ui\\header.blade.php',
    'c:\\xampp\\htdocs\\virratpos\\resources\\views\\layouts\\ui-admin.blade.php',
    'c:\\xampp\\htdocs\\virratpos\\resources\\views\\layouts\\admin.blade.php',
    'c:\\xampp\\htdocs\\virratpos\\resources\\views\\layouts\\admin-hybrid.blade.php',
    'c:\\xampp\\htdocs\\virratpos\\resources\\views\\components\\ui\\card.blade.php',
    'c:\\xampp\\htdocs\\virratpos\\resources\\views\\components\\ui\\table.blade.php'
];

let restored = new Set();

async function processLineByLine() {
  const fileStream = fs.createReadStream(logPath);

  const rl = readline.createInterface({
    input: fileStream,
    crlfDelay: Infinity
  });

  for await (const line of rl) {
    try {
      const entry = JSON.parse(line);
      if (entry.type === 'TOOL_RESPONSE' && entry.source === 'SYSTEM') {
        const content = entry.content || '';
        if (content.includes('File Path: `file:///')) {
          for (const target of filesToRestore) {
            const targetLower = target.replace(/\\/g, '/').toLowerCase();
            if (!restored.has(targetLower) && content.toLowerCase().includes(targetLower)) {
                
                let lines = content.split('\n');
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
                    fs.writeFileSync(target, originalContent.join('\n') + '\n');
                    console.log('Restored', target);
                    restored.add(targetLower);
                }
            }
          }
        }
      }
    } catch (e) {
      // ignore
    }
  }
}

processLineByLine();
