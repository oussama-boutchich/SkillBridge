import os, re, sys
sys.stdout.reconfigure(encoding='utf-8', errors='replace')
frontend = r'C:\xampp\htdocs\SkillBridge\CODE\frontend'
pattern = re.compile(r'content\s*:\s*["\']([^"\']*(?:fa-|<i\s|class=)[^"\']*)["\']')
issues = 0
for root, dirs, files in os.walk(frontend):
    for fname in files:
        if not fname.endswith(('.css', '.html')):
            continue
        fpath = os.path.join(root, fname)
        content = open(fpath, encoding='utf-8').read()
        matches = pattern.findall(content)
        if matches:
            issues += 1
            rel = fpath.replace(frontend + os.sep, '')
            print(f'ISSUE in {rel}:')
            for m in matches:
                print(f'  content: "{m[:80]}"')
if not issues:
    print('No FA icons in CSS content properties. All clean!')
