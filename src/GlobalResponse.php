<?php

namespace DiskominfoCore;

class GlobalResponse
{
    const RESPONSE_FAILED = "Invalid Request";
    const RESPONSE_ERROR = "Error";
    const RESPONSE_SUCCESS = "OK";
    const ERROR_MESSAGE_SPL = [
        'RC200' => 'Sukses',
        'RC400' => 'Bad Request - Error Server',
        'RC401' => 'Unauthorized (RFC 7235) - Tidak Mempunyai Akses',
        'RC403' => 'Forbidden - URL Tidak Bisa D akses',
        'RC404' => 'Not Found - Tidak Ditemukan',
        'RC405' => 'Method Not Allowed - Format'
    ];


}
