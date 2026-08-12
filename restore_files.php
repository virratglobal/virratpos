<?php
$log_path = getenv('USERPROFILE') . '/.gemini/antigravity-ide/brain/3011e5ac-3dc5-4d7f-b0a1-ab16a411bbe8/.system_generated/logs/transcript_full.jsonl';
$handle = fopen($log_path, "r");
$found_sidebar = false;
$found_header = false;
$found_card = false;
$found_table = false;
while (($line = fgets($handle)) !== false) {
    if (strpos($line, 'File Path: `file:///c:/xampp/htdocs/virratpos/resources/views/partials/ui/sidebar.blade.php') !== false && !$found_sidebar) {
        $entry = json_decode($line, true);
        if ($entry && isset($entry['content'])) {
            $content = $entry['content'];
            $lines = explode("\n", $content);
            $out = [];
            foreach ($lines as $l) {
                if (preg_match('/^\d+:\s(.*)/', $l, $m)) {
                    $out[] = rtrim($m[1], "\r");
                }
            }
            file_put_contents('c:/xampp/htdocs/virratpos/resources/views/partials/ui/sidebar.blade.php', implode("\n", $out));
            echo "Sidebar restored.\n";
            $found_sidebar = true;
        }
    }
    if (strpos($line, 'File Path: `file:///c:/xampp/htdocs/virratpos/resources/views/partials/ui/header.blade.php') !== false && !$found_header) {
        $entry = json_decode($line, true);
        if ($entry && isset($entry['content'])) {
            $content = $entry['content'];
            $lines = explode("\n", $content);
            $out = [];
            foreach ($lines as $l) {
                if (preg_match('/^\d+:\s(.*)/', $l, $m)) {
                    $out[] = rtrim($m[1], "\r");
                }
            }
            file_put_contents('c:/xampp/htdocs/virratpos/resources/views/partials/ui/header.blade.php', implode("\n", $out));
            echo "Header restored.\n";
            $found_header = true;
        }
    }
    if (strpos($line, 'File Path: `file:///c:/xampp/htdocs/virratpos/resources/views/components/ui/card.blade.php') !== false && !$found_card) {
        $entry = json_decode($line, true);
        if ($entry && isset($entry['content'])) {
            $content = $entry['content'];
            $lines = explode("\n", $content);
            $out = [];
            foreach ($lines as $l) {
                if (preg_match('/^\d+:\s(.*)/', $l, $m)) {
                    $out[] = rtrim($m[1], "\r");
                }
            }
            file_put_contents('c:/xampp/htdocs/virratpos/resources/views/components/ui/card.blade.php', implode("\n", $out));
            echo "Card restored.\n";
            $found_card = true;
        }
    }
    if (strpos($line, 'File Path: `file:///c:/xampp/htdocs/virratpos/resources/views/components/ui/table.blade.php') !== false && !$found_table) {
        $entry = json_decode($line, true);
        if ($entry && isset($entry['content'])) {
            $content = $entry['content'];
            $lines = explode("\n", $content);
            $out = [];
            foreach ($lines as $l) {
                if (preg_match('/^\d+:\s(.*)/', $l, $m)) {
                    $out[] = rtrim($m[1], "\r");
                }
            }
            file_put_contents('c:/xampp/htdocs/virratpos/resources/views/components/ui/table.blade.php', implode("\n", $out));
            echo "Table restored.\n";
            $found_table = true;
        }
    }
}
fclose($handle);
?>
