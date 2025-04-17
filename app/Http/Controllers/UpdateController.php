<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UpdateController extends Controller
{
    public function update()
    {
        $this->update1();
        $this->update2();
        $this->update3();
    }

    public function update1()
    {
        $documents = Document::where('date', null)->orderBy('id')->get();

        $months = ['ocak', 'şubat', 'mart', 'nisan', 'mayis', 'haziran', 'temmuz', 'ağustos', 'eylül', 'ekim', 'kasim', 'aralik'];
        $months1 = ['ocak', 'şubat', 'mart', 'nisan', 'mayıs', 'haziran', 'temmuz', 'agustos', 'eylul', 'ekim', 'kasım', 'aralık'];

        $years = ['2023', '2024', '2025'];

        $index =0;
        foreach ($documents as $document) {
            $string = Str::lower($document->alias);
            $segments = explode(' ', $string);
            $month = $year = false;

            foreach ($segments as $segment) {
                $month_index = array_search($segment, $months, false);
                
                if ($month_index !== false) {
                    $month = $month_index+1;    
                } else {
                    $month_index = array_search($segment, $months1, false);
                    if ($month_index !== false) {
                        $month = $month_index+1;  
                    }
                }
            }

            foreach ($segments as $segment) {
                $year_index = array_search($segment, $years, false);
                if ($year_index !== false) {
                    $year = $years[$year_index];
                }
            }

            // dump($months[$month_index], $years[$year_index]);

            if ($month && $year) {
                $date = Carbon::createFromFormat('Y m', $year.' '.$month)->tz('Europe/Istanbul')->endOfMonth();
                $document->update(['date' => $date]);

                dump($index.' '.$document->alias.' ->  '. $date);
                $index++;
            }

        }
    }

    /**
     * Display a listing of the resource.
     */
    public function update2()
    {
        $documents = Document::where('date', null)->orderBy('id')->get();

        $index = 0;

        foreach ($documents as $document) {

            $string = $document->description;

            $segments = explode('_', $string);

            if (count($segments) >= 2) {

                $len1 = strlen($segments[0]);
                $len2 = strlen($segments[1]);

                if (($len1 === 4 && $len2 === 2)) {
                    $year = $segments[0];
                    $month = $segments[1];

                    $date = Carbon::createFromFormat('Y m', $year.' '.$month)->tz('Europe/Istanbul')->endOfMonth();

                    $document->update(['date' => $date]);
                    dump($index.' '.$document->alias.' ->  '.$date);
                    $index++;
                }

                if (($len1 === 2 && $len2 === 4)) {
                    $month = $segments[0];
                    $year = $segments[1];

                    $date = Carbon::createFromFormat('Y m', $year.' '.$month)->tz('Europe/Istanbul')->endOfMonth();

                    $document->update(['date' => $date]);
                    dump($index.' '.$document->alias.' ->  '.$date);
                    $index++;
                }

                if ($len1 === 10) {

                    $date = Carbon::createFromFormat('d.m.Y', $segments[0])->tz('Europe/Istanbul');

                    $document->update(['date' => $date]);
                    dump($index.' '.$document->alias.' ->  '.$date);
                    $index++;
                }

            }
            // $document->update(['date' => $document->created_at]);

            // dump('docid: '. $document->alias, $segments, $document->date, 'index:' .$index);
            // $index++;

        }

        dd('end');
    }





    public function update3()
    {
        $documents = Document::where('date', null)->orderBy('id')->get();
        
        $index =0;

        foreach ($documents as $document) {
            $document->update(['date' => $document->created_at]);

            dump($index.' '.$document->alias.' ->  '. $document->date);
            $index++;
        }
    }



}
