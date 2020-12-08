<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use DatePeriod;

class MeditationController extends Controller
{
    public function index(Request $request) {
        $data = [];
        if ($request->year > date("Y") || $request->year < 2016 ) {
            $response = ['message' => 'Year parameter must be between 2016 and ' . date("Y")];
            return response($response, 400);
            // Yıl parametresi kontrol ediliyor.
            // 2016 yılında kuruldu sanırım şirket :)
            // İstenmeyen bir değer girilirse Bad Request dönüyor.
        }
        if ($request->month > 12 || $request->month < 1 ) {
            $response = ['message' => 'Month parameter must be between 1 and 12'];
            return response($response, 400);
            // Ay parametresi kontrol ediliyor.
            // İstenmeyen bir değer girilirse Bad Request dönüyor.
        }
        for($y = 2016; $y <= date("Y"); $y++) {
            for($i = 1; $i <= 12; $i++) {
                $data[$y][$i] = [
                    'completed_meditation'=> rand(0, 200),
                    // Maximum 200 meditasyon olduğunu varsayıyorum.
                    'completed_consecutive_meditation'=> $i === 2 ? rand(0, 28) : in_array($i, [4,6,9,11]) ? rand(0, 31) : rand(0,30),
                    // Bir ayda en fazla 30 gün üst üste meditasyon yapmış olabilir
                    // Burada Şubat ayı 28,
                    // Nisan, Haziran, Eylül ve Kasım ayları 31 günden oluşuyor
                    // Şubat ayı için artık yılları hesaba katmıyorum :)
                    // Ardışık olarak yaptığı meditasyon 
                    // sayısı bitirdiği meditasyon sayısından
                    // fazla olabilir, yarıda kalan
                    // meditasyonları da hesaba katıyorum,
                    // o yüzden burada kontrole gerek duymadım.
                    'total_meditation_time'=> rand(0, 1800)
                    // Burada günde en fazla 1 saat
                    // meditasyon yapabileceğini varsayıyorum.
                    // Dakika cinsinden dönüyor.
                ];
            }
        }
        $response[$request->year][$request->month] = $data[$request->year][$request->month];
        return response($response, 200);
    }

    public function lastSevenDays() {
        $today     = new DateTime(); // bugün
        $begin     = $today->sub(new DateInterval('P6D')); // 6 günlük interval
        $end       = new DateTime();
        $end       = $end->modify('+1 day'); // Bugün dahil
        $interval  = new DateInterval('P1D'); // 1 Günlük interval
        $daterange = new DatePeriod($begin, $interval, $end); // 7 günden bugüne kadar date period hesapla
        foreach ($daterange as $date) {
            $response[$date->format("Y-m-d")] = [
                'total_meditation_time' => rand(0, 1800)
            ];
        }
        return response($response, 200);
    }

    public function thisMonth() {
        $firstDay  = new DateTime(date("Y-m-01"));
        $today     = new DateTime(); // bugün
        $interval  = new DateInterval('P1D'); // 1 Günlük interval
        $daterange = new DatePeriod($firstDay, $interval, $today);
        foreach ($daterange as $date) {
            $meditated = rand(0,1); // Meditasyon yapıp yapmadığı bilgisi random üretiliyor
            $meditationTime = $meditated ? rand(0,1440) : 0;
            // Meditasyon yapmışsa random number üret, yapmamışsa toplam meditasyon 0
            // 1440 dakikaya kadar meditasyon yapmış olabilir
            // Günün hangi saatlerinde meditasyonun başlayıp bittiği istenmediği için
            // Bu bilgi, takvimde işaretlemek için yeterli olacaktır.
            $response[$date->format("Y-m-d")] = [
                'meditated' => $meditated,
                'total_meditation_time' => $meditationTime
            ];
        }
        return response($response, 200);
    }
}
