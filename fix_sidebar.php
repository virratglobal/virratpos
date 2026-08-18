<?php
$file = "c:/xampp/htdocs/virratpos/resources/views/partials/ui/sidebar.blade.php";
$content = file_get_contents($file);

// Replace main links
$content = preg_replace(
    '/style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; text-decoration: none; transition: all 0\.2s; \{\{ (.*?) \? \'background: #6063ee; color: #fffbff; font-weight: 500;\' : \'color: #464554;\' \}\}"\s*onmouseover="[^"]*"\s*onmouseout="[^"]*"/s',
    'class="sg-nav-link {{ $1 ? \'sg-active\' : \'\' }}"',
    $content
);

// Replace dropdown buttons
$content = preg_replace(
    '/style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 8px; color: #464554; background: none; border: none; cursor: pointer; transition: all 0\.2s; \{\{ (.*?) \? \'background: #6063ee; color: #fffbff;\' : \'\' \}\}"\s*onmouseover="[^"]*"\s*onmouseout="[^"]*"/s',
    'class="sg-nav-link w-full {{ $1 ? \'sg-active\' : \'\' }}"',
    $content
);

// Replace dropdown items
$content = preg_replace(
    '/style="display: block; padding: 8px 12px; border-radius: 6px; font-family: Inter, sans-serif; font-size: 13px; text-decoration: none; transition: all 0\.2s; \{\{ (.*?) \? \'background: #6063ee; color: #fffbff; font-weight: 500;\' : \'color: #464554;\' \}\}"\s*onmouseover="[^"]*"\s*onmouseout="[^"]*"/s',
    'class="sg-dropdown-link {{ $1 ? \'sg-active\' : \'\' }}"',
    $content
);

$style = "<style>
.sg-nav-link, .sg-nav-link.w-full {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s;
    color: #464554 !important;
    background: transparent !important;
    border: none;
    cursor: pointer;
}
.sg-nav-link:hover, .sg-nav-link.w-full:hover {
    background-color: #dce9ff !important;
    color: #0b1c30 !important;
}
.sg-nav-link.sg-active, .sg-nav-link.w-full.sg-active {
    background-color: #6063ee !important;
    color: #ffffff !important;
    font-weight: 500 !important;
}

.sg-dropdown-link {
    display: block;
    padding: 8px 12px;
    border-radius: 6px;
    font-family: Inter, sans-serif;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s;
    color: #464554 !important;
    background: transparent !important;
}
.sg-dropdown-link:hover {
    background-color: #dce9ff !important;
    color: #0b1c30 !important;
}
.sg-dropdown-link.sg-active {
    background-color: #6063ee !important;
    color: #ffffff !important;
    font-weight: 500 !important;
}
</style>\n";

// Prepend style if it's not already there
if (strpos($content, '<style>') === false) {
    $content = $style . $content;
}

file_put_contents($file, $content);
echo "Done";
?>
