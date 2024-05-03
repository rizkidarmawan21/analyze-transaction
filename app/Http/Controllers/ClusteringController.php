<?php

namespace App\Http\Controllers;

use Phpml\Clustering\KMeans;
use Illuminate\Http\Request;

class ClusteringController extends Controller
{
    public function ClusteringDataa()
    {
        // Data
        $data = [
            ['vintage', 'casuaal', 'dark'],
            ['classic', 'casuaal', 'Bright'],
            ['Stretwear', 'form', 'scandi'],
            ['indie', 'school', 'monochrome'],
            [
                'scndi', 'formaal', 'paastell'
            ],
            ['vintage', 'work', 'stretwear'],
            ['casual', 'work', 'bright'],
            ['vintage', 'dark', 'dark'],
            ['classic', 'casuaal', 'Bright'],
            ['vintage', 'casuaal', 'scandi'],
            ['classic', 'casuaal', 'monochrome'],
            ['Stretwear', 'casuaal', 'paastell'],
            ['indie', 'form', 'dark'],
            [
                'scndi', 'casuaal', 'Bright'
            ],
            ['classic', 'casuaal', 'scandi'],
            ['classic', 'form', 'monochrome'],
            ['Stretwear', 'school', 'paastell'],
            ['vintage', 'formaal', 'dark'],
            ['classic', 'work', 'Bright'],
            ['Stretwear', 'work', 'scandi'],
            [
                'indie', 'casuaal', 'monochrome'
            ],
            [
                'scndi', 'casuaal', 'paastell'
            ],
            ['vintage', 'form', 'dark'],
            [
                'casual', 'school', 'Bright'
            ],
            ['vintage', 'formaal', 'scandi'],
            ['classic', 'work', 'monochrome'],
            ['vintage', 'work', 'dark'],
            ['classic', 'dark', 'Bright'],
            ['Stretwear', 'casuaal', 'scandi'],
            [
                'indie', 'casuaal', 'monochrome'
            ],
            [
                'scndi', 'casuaal', 'paastell'
            ],
            ['classic', 'casuaal', 'stretwear'],
            ['classic', 'form', 'bright']
        ];

        // Menginisialisasi KMeans dengan 3 cluster
        $kmeans = new KMeans(3);

        // Melakukan klasterisasi
        $kmeans->cluster($data);
    }
}
