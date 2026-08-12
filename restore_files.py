import json
import os
import re

log_path = os.path.expanduser('~/.gemini/antigravity-ide/brain/3011e5ac-3dc5-4d7f-b0a1-ab16a411bbe8/.system_generated/logs/transcript_full.jsonl')
files_to_restore = [
    r'c:\xampp\htdocs\virratpos\resources\views\partials\ui\sidebar.blade.php',
    r'c:\xampp\htdocs\virratpos\resources\views\partials\ui\header.blade.php',
    r'c:\xampp\htdocs\virratpos\resources\views\layouts\ui-admin.blade.php',
    r'c:\xampp\htdocs\virratpos\resources\views\layouts\admin.blade.php',
    r'c:\xampp\htdocs\virratpos\resources\views\layouts\admin-hybrid.blade.php',
    r'c:\xampp\htdocs\virratpos\resources\views\components\ui\card.blade.php',
    r'c:\xampp\htdocs\virratpos\resources\views\components\ui\table.blade.php'
]

restored = set()

with open(log_path, 'r', encoding='utf-8') as f:
    for line in f:
        try:
            entry = json.loads(line)
            if entry.get('type') == 'TOOL_RESPONSE' and entry.get('source') == 'SYSTEM':
                content = entry.get('content', '')
                if 'File Path: ile:///' in content:
                    # Find which file it is
                    for target in files_to_restore:
                        if target.lower() not in restored and target.replace('\\', '/').lower() in content.lower():
                            # Extract the file content
                            # The format is:
                            # 1: <!-- Mobile sidebar backdrop -->
                            # 2: ...
                            lines = content.split('\n')
                            original_content = []
                            is_code = False
                            for l in lines:
                                match = re.match(r'^\d+:\s(.*)', l)
                                if match:
                                    original_content.append(match.group(1))
                                    is_code = True
                                elif is_code and 'The above content shows the entire' not in l and not l.startswith('The following code has been modified'):
                                    pass # sometimes there are empty lines or something, but usually it matches
                            
                            # Let's rebuild the file
                            if original_content:
                                with open(target, 'w', encoding='utf-8') as out_f:
                                    out_f.write('\n'.join(original_content) + '\n')
                                print(f'Restored {target}')
                                restored.add(target.lower())
        except Exception as e:
            print('Error:', e)
            pass

print('Done')
