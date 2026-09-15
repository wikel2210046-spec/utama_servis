<?php

if (!function_exists('kirim_wa')) {
    /**
     * Kirim notifikasi WhatsApp via Fonnte API Gateway
     * 
     * @param string $target Nomor HP tujuan (format: 08xxx atau 628xxx)
     * @param string $pesan Teks pesan yang akan dikirim
     * @return array Respon dari API Fonnte
     */
    function kirim_wa($target, $pesan)
    {
        // 1. Bersihkan karakter non-numerik
        $target = preg_replace('/[^0-9]/', '', (string)$target);

        // 2. Format nomor HP ke standar internasional 62
        if (substr($target, 0, 1) === '0') {
            $target = '62' . substr($target, 1);
        } elseif (substr($target, 0, 1) === '8') {
            $target = '62' . $target;
        }

        // 3. Ambil Token dari file .env
        $token = env('FONNTE_TOKEN') ?: getenv('FONNTE_TOKEN') ?: '57ewxjwHSGccEuRwZvM4';

        if (empty($token)) {
            log_message('error', 'Fonnte WA Error: Token belum diset di .env');
            return ['status' => false, 'reason' => 'Token WA belum diset.'];
        }

        // 4. Kirim request ke Fonnte API
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'target' => $target,
                'message' => $pesan,
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $token,
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            log_message('error', 'Fonnte WA cURL Error: ' . $err);
            return ['status' => false, 'reason' => $err];
        }

        $result = json_decode($response, true);
        if (empty($result['status'])) {
            log_message('error', 'Fonnte WA Response Error: ' . $response);
        }

        return $result ?: ['status' => false, 'response' => $response];
    }
}
