<?php


if (!function_exists('newRowDipa')) {
    function newRowDipa()
    {
        return "</tr><tr>";
    }
}
if (!function_exists('categoryTimeline')) {
    function categoryTimeline($data)
    {
        if ($data == 'creat') {
            return "Pembuatan Usulan";
        } else if ($data == 'revision') {
            return "Revisi";
        } else if ($data == 'pra-creat') {
            return "Indikatif";
        } else
            return $data;
    }
}

if (!function_exists('statusDipa')) {
    function statusDipa($data)
    {
        if ($data == 'accept') {
            return "Sedang di Buat";
        } else if ($data == 'wait-perencanaan') {
            return "Menunggu Perencanaan";
        } else if ($data == 'wait-spi') {
            return "Menunggu Penelaahan";
        } else if ($data == 'wait-ppk') {
            return "Menunggu PPK";
        } else if ($data == 'wait-kp') {
            return "Menunggu Persetujuan Atasan";
        } else if ($data == 'reject-kp') {
            return "Ditolak Atasan";
        } else if ($data == 'reject-perencanaan') {
            return "Ditolak Perencanaan";
        } else if ($data == 'reject-spi') {
            return "Ditolak SPI";
        } else if ($data == 'reject-perencanaan') {
            return "Ditolak PPK";
        } elseif ($data == 'release') {
            return "Sudah Terbit";
        } elseif ($data == 'wait-kpa') {
            return "Menunggu KPA";
        } elseif ($data == 'reject-kpa') {
            return "Ditolak KPA";
        } else
            return $data;
    }
}

if (!function_exists('layoutConfig')) {
    function layoutConfig()
    {

        if (Request::is('modern-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vlm');
        } else if (Request::is('modern-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vdm');
        } else if (Request::is('collapsible-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.cm');
        } else if (Request::is('horizontal-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm');
        } else if (Request::is('horizontal-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm');
        }

        // RTL

        elseif (Request::is('rtl/modern-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vlm-rtl');
        } else if (Request::is('rtl/modern-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vdm-rtl');
        } else if (Request::is('rtl/collapsible-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.cm-rtl');
        } else if (Request::is('rtl/horizontal-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm-rtl');
        } else if (Request::is('rtl/horizontal-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hdm-rtl');
        }

        // Login

        elseif (Request::is('login')) {

            $__getConfiguration = Config::get('app-config.layout.vlm');
        } else {
            $__getConfiguration = Config::get('barebone-config.layout.bb');
        }

        return $__getConfiguration;
    }
}


if (!function_exists('getRouterValue')) {
    function getRouterValue()
    {

        if (Request::is('modern-light-menu/*')) {

            $__getRoutingValue = '/modern-light-menu';
        } else if (Request::is('modern-dark-menu/*')) {

            $__getRoutingValue = '/modern-dark-menu';
        } else if (Request::is('collapsible-menu/*')) {

            $__getRoutingValue = '/collapsible-menu';
        } else if (Request::is('horizontal-light-menu/*')) {

            $__getRoutingValue = '/horizontal-light-menu';
        } else if (Request::is('horizontal-dark-menu/*')) {

            $__getRoutingValue = '/horizontal-dark-menu';
        }

        // RTL

        elseif (Request::is('rtl/modern-light-menu/*')) {

            $__getRoutingValue = '/rtl/modern-light-menu';
        } else if (Request::is('rtl/modern-dark-menu/*')) {

            $__getRoutingValue = '/rtl/modern-dark-menu';
        } else if (Request::is('rtl/collapsible-menu/*')) {

            $__getRoutingValue = '/rtl/collapsible-menu';
        } else if (Request::is('rtl/horizontal-light-menu/*')) {

            $__getRoutingValue = '/rtl/horizontal-light-menu';
        } else if (Request::is('rtl/horizontal-dark-menu/*')) {

            $__getRoutingValue = '/rtl/horizontal-dark-menu';
        }

        // Login

        elseif (Request::is('login')) {

            $__getRoutingValue = '/modern-light-menu';
        } else {
            $__getRoutingValue = '';
        }

        return $__getRoutingValue;
    }
}

if (!function_exists('terbilang')) {
    function terbilang($number)
    {
        $bilangan = [
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas',
        ];

        if ($number < 12) {
            return $bilangan[$number];
        } elseif ($number < 20) {
            return terbilang($number - 10) . ' belas';
        } elseif ($number < 100) {
            return terbilang($number / 10) . ' puluh ' . terbilang($number % 10);
        } elseif ($number < 200) {
            return ' seratus ' . terbilang($number - 100);
        } elseif ($number < 1000) {
            return terbilang($number / 100) . ' ratus ' . terbilang($number % 100);
        } elseif ($number < 2000) {
            return ' seribu ' . terbilang($number - 1000);
        } elseif ($number < 1000000) {
            return terbilang($number / 1000) . ' ribu ' . terbilang($number % 1000);
        } elseif ($number < 1000000000) {
            return terbilang($number / 1000000) . ' juta ' . terbilang($number % 1000000);
        } elseif ($number < 1000000000000) {
            return terbilang($number / 1000000000) . ' milyar ' . terbilang($number % 1000000000);
        } elseif ($number < 1000000000000000) {
            return terbilang($number / 1000000000000) . ' trilyun ' . terbilang($number % 1000000000000);
        } else {
            return 'Maaf, tolong masukkan angka yang lebih kecil.';
        }
    }
}

if (!function_exists('status_receipt')) {
    function status_receipt($var)
    {
        if ($var == 'draft') {
            return "<span class='badge badge-light-secondary'>Draft</span>";
        } elseif ($var == 'wait-verificator') {
            return "<span class='badge badge-light-warning'>Menunggu Verifikator</span>";
        } elseif ($var == 'wait-ppk') {
            return "<span class='badge badge-light-primary'>Menunggu PPK</span>";
        } elseif ($var == "wait-spi") {
            return "<span class='badge badge-light-primary'>Menunggu SPI</span>";
        } elseif ($var == "wait-treasurer") {
            return "<span class='badge badge-light-primary'>Menunggu Bendahara</span>";
        } elseif ($var == "reject-verificator") {
            return "<span class='badge badge-light-danger'>Tolak Verifikator</span>";
        } elseif ($var == "reject-ppk") {
            return "<span class='badge badge-light-danger'>Tolak PPK</span>";
        } elseif ($var == "reject-spi") {
            return "<span class='badge badge-light-danger'>Tolak SPI</span>";
        } elseif ($var == "reject-treasurer") {
            return "<span class='badge badge-light-danger'>Tolak Bendahara</span>";
        } elseif ($var == "accept") {
            return "<span class='badge badge-light-success'>Selesai</span>";
        } else
            return "-";
    }
}
if (!function_exists('status_app_keuangan')) {
    function status_app_keuangan($var)
    {
        if ($var == "N") {
            return "<span class='badge badge-light-danger'>Belum Entry</span>";
        } else
        if ($var == "R") {
            return "<span class='badge badge-light-warning'>Belum terbit SP2D</span>";
        } elseif ($var == "Y") {
            return "<span class='badge badge-light-success'>Selesai</span>";
        } else
            return "-";
    }
}
if (!function_exists('dompdf_checkbox_blank')) {
    function dompdf_checkbox_blank($number, $desc, $span = 'ADA')
    {
        return "<tr class='no-border'>
                                    <td class='no-border' style='width: 10px'>$number.</td>
                                    <td class='no-border'>$desc</td>
                                    <td class='no-border'><div class='box'></div></td>
                                    <td class='no-border'>$span </td>
     </tr>";
    }
}

if (!function_exists('dompdf_checkbox')) {
    function dompdf_checkbox($number, $desc, $span = 'ADA', $res = false)
    {
        if ($res == 'Y') {
            $checked = 'checked';
        } else {
            $checked = '';
        }
        return "<tr class='no-border'>
                                    <td class='no-border' style='width: 10px'>$number.</td>
                                    <td class='no-border'>$desc</td>
                                    <td class='no-border' style='width: 10px'>
                                        <input style='vertical-align: top ;  transform: scale(1.5); margin-top:  -5px !important ; padding-top: -10px  !important ;height: 15px !important' type='checkbox' ' . $checked . '>
                                        </td>
                                </tr>";
    }
}
