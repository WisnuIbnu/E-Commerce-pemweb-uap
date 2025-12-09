import os

file_path = r'c:\laragon\www\E-Commerce-group-15\resources\views\welcome.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_lines = []
skip = False
found_start = False

for i, line in enumerate(lines):
    # Color replacements (global)
    line = line.replace('text-[#f53003]', 'text-[#D4AF37]')
    line = line.replace('dark:text-[#FF4433]', 'dark:text-[#D4AF37]')
    # Also replacing stroke color if present (lines 207, 208 etc had stroke-[#FF750F])
    line = line.replace('stroke-[#FF750F]', 'stroke-[#D4AF37]') 
    
    # Identify the start of the magma block
    if 'bg-[#fff2f2] dark:bg-[#1D0002]' in line and 'relative' in line:
        found_start = True
        skip = True
        # Insert new content
        new_lines.append('                <div class="relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden">\n')
        new_lines.append('                    <img src="{{ asset(\'images/hero-marble-gold.png\') }}" class="w-full h-full object-cover" alt="Hero Background">\n')
        new_lines.append('                </div>\n')
        continue
    
    if skip:
        # We are skipping the magma block. We stop skipping when we see </main>
        # The magma block ends with a </div> just before </main>
        if '</main>' in line:
            skip = False
            new_lines.append(line)
    else:
        new_lines.append(line)

if not found_start:
    print("Error: Could not find the start of the magma block.")
else:
    with open(file_path, 'w', encoding='utf-8') as f:
        f.writelines(new_lines)
    print("Successfully updated welcome.blade.php")
