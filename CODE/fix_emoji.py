import os, sys
sys.stdout.reconfigure(encoding='utf-8', errors='replace')

frontend = r'C:\xampp\htdocs\SkillBridge\CODE\frontend'

ICON = lambda cls: f'<i class="{cls}"></i>'

extra_replacements = [
    ('\U0001f4e9', ICON('fa-solid fa-envelope')),           # 📩
    ('\u2715', '\u00d7'),                                    # ✕ -> ×
    ('\U0001f6ab', ICON('fa-solid fa-ban')),                # 🚫
    ('\U0001f535', ''),                                      # 🔵 blue circle -> remove
    ('\u2699\ufe0f', ICON('fa-solid fa-gear')),             # ⚙️
    ('\u2699', ICON('fa-solid fa-gear')),                   # ⚙
    ('\u2705', ICON('fa-solid fa-circle-check')),           # ✅
    ('\u274c', ICON('fa-solid fa-circle-xmark')),           # ❌
    ('\U0001f534', ''),                                      # 🔴 red circle -> remove
    ('\U0001f7e1', ''),                                      # 🟡 yellow circle -> remove
    ('\U0001f7e2', ''),                                      # 🟢 green circle -> remove
    ('\U0001f7e0', ''),                                      # 🟠 orange circle -> remove
    ('\U0001f4ce', ICON('fa-solid fa-paperclip')),          # 📎
    ('\U0001f44b', 'Hi,'),                                   # 👋
    ('\u270f\ufe0f', ICON('fa-solid fa-pen-to-square')),    # ✏️
    ('\u270f', ICON('fa-solid fa-pen-to-square')),          # ✏
    ('\U0001f5d1\ufe0f', ICON('fa-solid fa-trash')),        # 🗑️
    ('\U0001f5d1', ICON('fa-solid fa-trash')),              # 🗑
    ('\U0001f6e1\ufe0f', ICON('fa-solid fa-shield-halved')),# 🛡️
    ('\U0001f6e1', ICON('fa-solid fa-shield-halved')),      # 🛡
    ('\U0001f4ca', ICON('fa-solid fa-chart-bar')),          # 📊
    ('\U0001f4c8', ICON('fa-solid fa-chart-line')),         # 📈
    ('\U0001f517', ICON('fa-solid fa-link')),               # 🔗
    ('\U0001f310', ICON('fa-solid fa-globe')),              # 🌐
    ('\U0001f512', ICON('fa-solid fa-lock')),               # 🔒
    ('\u26a0\ufe0f', ICON('fa-solid fa-triangle-exclamation')),  # ⚠️
    ('\u26a0', ICON('fa-solid fa-triangle-exclamation')),   # ⚠
    ('\u2714\ufe0f', ICON('fa-solid fa-check')),            # ✔️
    ('\u2714', ICON('fa-solid fa-check')),                  # ✔
    ('\u2713', ICON('fa-solid fa-check')),                  # ✓
    ('\u2139\ufe0f', ICON('fa-solid fa-circle-info')),      # ℹ️
    ('\u2139', ICON('fa-solid fa-circle-info')),            # ℹ
    ('\U0001f4ec', ICON('fa-solid fa-envelope-open')),      # 📬
    ('\U0001f4c5', ICON('fa-regular fa-calendar')),         # 📅
    ('\U0001f4cd', ICON('fa-solid fa-location-dot')),       # 📍
    ('\U0001f4b0', ICON('fa-solid fa-dollar-sign')),        # 💰
    ('\U0001f3af', ICON('fa-solid fa-bullseye')),           # 🎯
    ('\u2b50\ufe0f', ICON('fa-solid fa-star')),             # ⭐️
    ('\u2b50', ICON('fa-solid fa-star')),                   # ⭐
    ('\U0001f4a1', ICON('fa-solid fa-lightbulb')),          # 💡
    ('\U0001f91d', ICON('fa-solid fa-handshake')),          # 🤝
    ('\U0001f4e7', ICON('fa-regular fa-envelope')),         # 📧
    ('\U0001f4f1', ICON('fa-solid fa-mobile')),             # 📱
    ('\U0001f3eb', ICON('fa-solid fa-graduation-cap')),     # 🏫
    ('\U0001f4c3', ICON('fa-solid fa-file-lines')),         # 📃
    ('\U0001f4e4', ICON('fa-solid fa-file-export')),        # 📤
    ('\U0001f4e5', ICON('fa-solid fa-file-import')),        # 📥
    ('\U0001f4af', '100'),                                   # 💯
    ('\U0001f680', ICON('fa-solid fa-rocket')),             # 🚀
    ('\U0001f6a8', ICON('fa-solid fa-triangle-exclamation')),# 🚨
    ('\U0001f3c6', ICON('fa-solid fa-trophy')),             # 🏆
    ('\U0001f393', ICON('fa-solid fa-graduation-cap')),     # 🎓
    ('\U0001f4bc', ICON('fa-solid fa-briefcase')),          # 💼
    ('\U0001f465', ICON('fa-solid fa-users')),              # 👥
    ('\U0001f464', ICON('fa-solid fa-circle-user')),        # 👤
    ('\U0001f4dd', ICON('fa-solid fa-pen-to-square')),      # 📝
    ('\U0001f4cb', ICON('fa-solid fa-clipboard-list')),     # 📋
    ('\U0001f4dc', ICON('fa-solid fa-scroll')),             # 📜
    ('\U0001f3e2', ICON('fa-solid fa-building')),           # 🏢
    ('\U0001f50d', ICON('fa-solid fa-magnifying-glass')),   # 🔍
    ('\U0001f514', ICON('fa-solid fa-bell')),               # 🔔
    ('\U0001f4c4', ICON('fa-solid fa-file-lines')),         # 📄
    ('\u229e', ICON('fa-solid fa-gauge-high')),             # ⊞
    ('\u2630', ICON('fa-solid fa-bars')),                   # ☰
    ('\U0001f6aa', ICON('fa-solid fa-right-from-bracket')), # 🚪
    ('\u23f3', ICON('fa-regular fa-clock')),                # ⏳
    ('\u23f0', ICON('fa-solid fa-clock')),                  # ⏰
    ('© 2024 SkillBridge', '© 2026 SkillBridge'),
    ('© 2025 SkillBridge', '© 2026 SkillBridge'),
]

count = 0
for root, dirs, files in os.walk(frontend):
    for fname in files:
        if not fname.endswith(('.js', '.html')):
            continue
        fpath = os.path.join(root, fname)
        with open(fpath, 'r', encoding='utf-8') as f:
            content = f.read()
        original = content
        for old, new in extra_replacements:
            content = content.replace(old, new)
        if content != original:
            count += 1
            with open(fpath, 'w', encoding='utf-8') as f:
                f.write(content)
            rel = fpath.replace(frontend + os.sep, '')
            print(f'Fixed: {rel}')

print(f'\nDone. Fixed {count} files.')
