<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeditationController extends Controller
{
    public function index(Request $request) {
        $data = [];
        if ($request->year > date("Y")) {
            $response = ['message' => 'Year parameter can not be bigger than current year ' . date("Y")];
            return response($response, 400);
            //Current yıl kontrolü yapılıyor.
        } else if ($request->year < 2016) {
            $response = ['message' => 'Year parameter should be bigger than 2016 '];
            return response($response, 400);
        }
        for($y = 2016; $y <= date("Y"); $y++) {
            // 2016 yılında kuruldu sanırım şirket :)
            for($i = 1; $i <= 12; $i++) {
                $data[$y][$i] = [
                    'completed_meditation'=> rand(0, 200),
                    // 200 meditasyon olduğunu varsayıyorum.
                    'completed_consecutive_meditation'=> rand(0, 30),
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
        $response = $data[$request->year][$request->month];
        return response($response, 200);
    }
}
