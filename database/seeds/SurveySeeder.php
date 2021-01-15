<?php

use App\Survey;
use App\SurveyOption;
use App\SurveyQuestion;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Survey dari PME BBLK Palembang Siklus 1 2018
        Survey::create([
            'id' => 1,
            'title' => 'Pendapat Responden Tentang Pelayanan Publik'
        ]);

        $questions = [
            1 => [
                'title' => 'Bagaiman kejelasan persyaratan yang harus dilengkapi untuk menjadi peserta PME di BBLK?',
                'options' => [
                    1 => [
                        'title' => 'Kurang Jelas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup Jelas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Jelas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat jelas',
                        'value' => 4,
                    ]
                ]
            ],
            2 => [
                'title' => 'Bagaimana kemudahan pemenuhan persyaratan mengikuti PME?',
                'options' => [
                    1 => [
                        'title' => 'Kurang Mudah',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup Mudah',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Mudah',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat mudah',
                        'value' => 4,
                    ]
                ]
            ],
            3 => [
                'title' => 'Bagaiman kejelasan alur pelaksanaan PME di BBLK?',
                'options' => [
                    1 => [
                        'title' => 'Kurang jelas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup jelas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Jelas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat jelas',
                        'value' => 4,
                    ]
                ]
            ],
            4 => [
                'title' => 'Bagaimana kemudahan alur kegiatan PME di BBLK?',
                'options' => [
                    1 => [
                        'title' => 'Kurang mudah',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup mudah',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Mudah',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat mudah',
                        'value' => 4,
                    ]
                ]
            ],
            5 => [
                'title' => 'Bagaimana tingkat kepuasan anda terhadap kecepatan petugas instalasi mikrobiologi dalam memberikan layanan dalam kegiatan PME?',
                'options' => [
                    1 => [
                        'title' => 'Tidak puas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup puas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Puas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat puas',
                        'value' => 4,
                    ]
                ]
            ],
            6 => [
                'title' => 'Bagaimana tingkat kepuasan anda terhadap kecepatan petugas instalasi imunologi dalam memberikan layanan dalam kegiatan PME?',
                'options' => [
                    1 => [
                        'title' => 'Tidak puas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup puas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Puas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat puas',
                        'value' => 4,
                    ]
                ]
            ],
            7 => [
                'title' => 'Bagaimana tingkat kepuasan anda terhadap kecepatan petugas instalasi patologi dalam memberikan layanan dalam kegiatan PME?',
                'options' => [
                    1 => [
                        'title' => 'Tidak puas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup puas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Puas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat puas',
                        'value' => 4,
                    ]
                ]
            ],
            8 => [
                'title' => 'Bagaimana tingkat kepuasan anda terhadap kecepatan petugas instalasi kimia kesehatan dalam memberikan layanan dalam kegiatan PME?',
                'options' => [
                    1 => [
                        'title' => 'Tidak puas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup puas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Puas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat puas',
                        'value' => 4,
                    ]
                ]
            ],
            9 => [
                'title' => 'Bagaimana tingkat kepuasan anda terhadap kecepatan petugas admin dalam memberikan layanan dalam kegiatan PME?',
                'options' => [
                    1 => [
                        'title' => 'Tidak puas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup puas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Puas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat puas',
                        'value' => 4,
                    ]
                ]
            ],
            10 => [
                'title' => 'Bagaimana kejelasan informasi waktu kegiatan PME di BBLK?',
                'options' => [
                    1 => [
                        'title' => 'Kurang jelas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup jelas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Jelas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat jelas',
                        'value' => 4,
                    ]
                ]
            ],
            11 => [
                'title' => 'Apakah waktu kegiatan PME BBLK sudah sesuai kebutuhan anda?',
                'options' => [
                    1 => [
                        'title' => 'Tidak sesuai',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup sesuai',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Sesuai',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat sesuai',
                        'value' => 4,
                    ]
                ]
            ],
            12 => [
                'title' => 'Bagaimana kejelasan perhitungan biaya kepesertaan PME?',
                'options' => [
                    1 => [
                        'title' => 'Tidak jelas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup jelas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Jelas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat jelas',
                        'value' => 4,
                    ]
                ]
            ],
            13 => [
                'title' => 'Bagaimana kemudahan cara pembayaran?',
                'options' => [
                    1 => [
                        'title' => 'Tidak mudah',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup mudah',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Mudah',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat mudah',
                        'value' => 4,
                    ]
                ]
            ],
            14 => [
                'title' => 'Puaskah anda akan biaya yang anda bayarkan dengan pelayanan PME yang diberikan oleh BBLK Palembang?',
                'options' => [
                    1 => [
                        'title' => 'Tidak puas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup puas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Puas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat puas',
                        'value' => 4,
                    ]
                ]
            ],
            15 => [
                'title' => 'Bagaimana kelengkapan jenis parameter PME di BBLK Palembang?',
                'options' => [
                    1 => [
                        'title' => 'Tidak lengkap',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup lengkap',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Lengkap',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat lengkap',
                        'value' => 4,
                    ]
                ]
            ],
            16 => [
                'title' => 'Puaskah anda terhadap kualitas petugas dalam menyampaikan informasi layanan kegiatan PME yang diberikan di BBLK Palembang?',
                'options' => [
                    1 => [
                        'title' => 'Tidak puas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup puas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Puas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat puas',
                        'value' => 4,
                    ]
                ]
            ],
            17 => [
                'title' => 'Apakah petugas mampu melakukan tugasnya dengan baik?',
                'options' => [
                    1 => [
                        'title' => 'Tidak mampu',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup mampu',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Mampu',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat mampu',
                        'value' => 4,
                    ]
                ]
            ],
            18 => [
                'title' => 'Bagaimana kesopanan  (menghormati, menghargai) petugas dalam memberikan pelayanan?',
                'options' => [
                    1 => [
                        'title' => 'Tidak sopan',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup sopan',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Sopan',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat sopan',
                        'value' => 4,
                    ]
                ]
            ],
            19 => [
                'title' => 'Bagaimana sikap ramah tamah (salam, senyum, sapa) petugas saat memberikan pelayan?',
                'options' => [
                    1 => [
                        'title' => 'Tidak ramah',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup ramah',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Ramah',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat ramah',
                        'value' => 4,
                    ]
                ]
            ],
            20 => [
                'title' => 'Bagaimana kesigapan petugas dalam memberikan pelayanan?',
                'options' => [
                    1 => [
                        'title' => 'Lambat',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup cepat',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Cepat',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat cepat',
                        'value' => 4,
                    ]
                ]
            ],
            21 => [
                'title' => 'Bagaimana kesesuaian pelaksanaan PME dengan skema PME?',
                'options' => [
                    1 => [
                        'title' => 'Tidak sesuai',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup sesuai',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Sesuai',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat sesuai',
                        'value' => 4,
                    ]
                ]
            ],
            22 => [
                'title' => 'Bagaimana kejelasan prosedur dalam menyampaikan saran/ masukan/ keluhan?',
                'options' => [
                    1 => [
                        'title' => 'Tidak jelas',
                        'value' => 1,
                    ],
                    2 => [
                        'title' => 'Cukup jelas',
                        'value' => 2,
                    ],
                    3 => [
                        'title' => 'Jelas',
                        'value' => 3,
                    ],
                    4 => [
                        'title' => 'Sangat jelas',
                        'value' => 4,
                    ]
                ]
            ],
        ];

        foreach ($questions as $question) {
            $q = SurveyQuestion::create([
                'survey_id' => 1,
                'title' => $question['title'],
            ]);

            foreach ($question['options'] as $option) {
                SurveyOption::create([
                    'survey_question_id' => $q->id,
                    'title' => $option['title'],
                    'score' => $option['value'],
                ]);
            }
        }
    }
}
