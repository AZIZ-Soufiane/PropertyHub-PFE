<?php
/**
 * E2E test using PHP streams (no curl).
 */

require __DIR__ . '/vendor/autoload.php';

$base = 'http://127.0.0.1:8000';

class StreamClient {
    private $cookies = '';
    public function request($method, $url, $body = null) {
        $parts = parse_url($url);
        $path = $parts['path'] . (isset($parts['query']) ? '?' . $parts['query'] : '');
        $host = $parts['host'];
        $port = $parts['port'] ?? 80;

        $headers = [
            "$method $path HTTP/1.1",
            "Host: $host",
            "User-Agent: StreamClient/1.0",
            "Connection: close",
        ];
        if ($this->cookies) $headers[] = "Cookie: {$this->cookies}";

        $bodyStr = null;
        if ($body !== null) {
            $bodyStr = is_array($body) ? http_build_query($body) : $body;
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            $headers[] = "Content-Length: " . strlen($bodyStr);
        }

        $fp = stream_socket_client("tcp://$host:$port", $errno, $errstr, 15);
        if (!$fp) return ['code' => 0, 'headers' => '', 'body' => "ERROR: $errstr"];

        fwrite($fp, implode("\r\n", $headers) . "\r\n\r\n" . ($bodyStr ?? ''));
        $raw = '';
        while (!feof($fp)) $raw .= fgets($fp, 4096);
        fclose($fp);

        $raw = preg_replace('/^HTTP\/1\.1 /', '', $raw, 1);
        [$status, $rest] = explode("\r\n", $raw, 2);
        $code = (int) $status;
        $hEnd = strpos($rest, "\r\n\r\n");
        $hdrs = substr($rest, 0, $hEnd);
        $body = substr($rest, $hEnd + 4);

        if (preg_match_all('/^Set-Cookie:\s*([^\r]+)/mi', $hdrs, $m)) {
            $parts = [];
            foreach ($m[1] as $c) {
                $parts = array_merge($parts, explode('; ', explode(';', $c)[0]));
            }
            $map = [];
            if ($this->cookies) {
                foreach (explode('; ', $this->cookies) as $p) {
                    [$k, $v] = explode('=', $p, 2);
                    $map[trim($k)] = trim($v);
                }
            }
            foreach ($parts as $p) {
                [$k, $v] = explode('=', $p, 2);
                $map[trim($k)] = trim($v);
            }
            $out = [];
            foreach ($map as $k => $v) $out[] = "$k=$v";
            $this->cookies = implode('; ', $out);
        }

        $location = null;
        if (preg_match('/^Location:\s*([^\r]+)/mi', $hdrs, $lm)) $location = trim($lm[1]);

        return ['code' => $code, 'headers' => $hdrs, 'body' => $body, 'location' => $location, 'cookies' => $this->cookies];
    }
    public function reset() { $this->cookies = ''; }
}

function testLogin($email, $password, $name) {
    global $base;
    echo "\n=== Testing $name ($email) ===\n";

    $c = new StreamClient();
    $r = $c->request('GET', "$base/login");
    if (!preg_match('/name="_token" value="([^"]+)"/', $r['body'], $m)) {
        echo "CSRF token not found (status: {$r['code']})\n";
        return;
    }
    $csrf = $m[1];
    echo "Got CSRF token\n";

    $r = $c->request('POST', "$base/login", [
        '_token' => $csrf,
        'email' => $email,
        'password' => $password,
    ]);
    echo "Login: {$r['code']} -> {$r['location']}\n";

    if ($r['code'] === 302 && $r['location']) {
        $loc = $r['location'];
        if (str_starts_with($loc, 'http://127.0.0.1') || str_starts_with($loc, 'http://localhost')) {
            $loc = str_replace(['http://127.0.0.1', 'http://localhost'], $base, $loc);
        } elseif (!str_starts_with($loc, 'http')) {
            $loc = $base . $loc;
        }
        $d = $c->request('GET', $loc);
        echo "  Dashboard: {$d['code']} (" . strlen($d['body']) . " bytes)\n";
        if (preg_match('/<title>([^<]+)/', $d['body'], $m)) echo "  Title: {$m[1]}\n";

        foreach (['/agent/dashboard', '/agent/properties', '/agent/appointments', '/admin/dashboard', '/admin/users'] as $ep) {
            $rr = $c->request('GET', $base . $ep);
            $loc = $rr['location'] ?? '';
            if (str_contains($loc, '127.0.0.1/login') || str_contains($loc, 'localhost/login')) {
                $loc = 'redirected to login';
            } elseif ($rr['code'] === 500) {
                if (preg_match('/exception[\s\S]{0,300}?/i', $rr['body'], $em)) {
                    $loc = '500: ' . substr(strip_tags($rr['body']), 0, 200);
                }
            }
            $status = $rr['code'] === 200 ? 'OK' : ($rr['code'] === 302 ? "redirect" : ($rr['code'] === 500 ? "ERROR" : "code={$rr['code']}"));
            echo "  $ep: {$rr['code']} ($status)" . ($loc ? " [$loc]" : '') . "\n";
        }
    } else {
        if (preg_match('/errors are\s*<\/div>\s*<ul[^>]*>(.+?)<\/ul>/s', $r['body'], $m)) {
            $errText = strip_tags($m[1]);
            echo "  Login error: $errText\n";
        }
    }
}

testLogin('admin@propertyhub.com', 'password', 'Admin');
testLogin('john.agent@propertyhub.com', 'password', 'Agent');
testLogin('alice.buyer@example.com', 'password', 'Buyer');
testLogin('admin@propertyhub.com', 'wrongpass', 'BadPassword');
