<template>
    <div class="ui form">
        <table class="ui table celled">
            <thead>
            <tr>
                <th class="center aligned" style="width: 20%">Kode Peserta</th>
                <th class="center aligned" style="width: 40%">Instansi</th>
                <th class="center aligned" style="width: 40%">Personil Penghubung</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">{{ form.participant.number }}</td>
                <td class="center aligned">{{ form.participant.name }}</td>
                <td class="center aligned">{{ form.participant.username }}</td>
            </tr>
            </tbody>
        </table>

        <table class="ui table celled">
            <thead>
            <tr>
                <th class="center aligned" style="width: 30%">Tanggal Penerimaan</th>
                <th class="center aligned" style="width: 30%">Tanggal Pemeriksaan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">{{ form.date.received }}</td>
                <td class="center aligned">{{ form.date.examination }}</td>
            </tr>
            </tbody>
        </table>

        <table class="ui table celled">
            <thead>
            <tr>
                <th class="center aligned">{{ '#' }}</th>
                <th class="center aligned">{{ 'Kode Panel' }}</th>
                <th class="center aligned">{{ 'Kualitas Bahan' }}</th>
                <th class="center aligned">{{ 'Deskripsi Kualitas Bahan' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(panel, index) in panels">
                <th class="center aligned" style="width: 5%">{{ `${index+1}` }}</th>

                <td style="width: 10%" class="center aligned">
                    {{ panel.number }}
                </td>

                <td style="width: 15%" class="center aligned">
                    {{ panel.quality }}
                </td>

                <td style="width: 60%" class="center aligned">
                    {{ panel.qualityDescription }}
                </td>
            </tr>
            </tbody>
        </table>

        <table class="ui table celled">
            <thead>
            <tr>
                <th class="center aligned" style="width: 12%">{{ 'Keterangan' }}</th>
                <th class="center aligned" style="width: 22%">{{ 'Metode Pemeriksaan' }}</th>
                <th class="center aligned" style="width: 22%">{{ 'Nama Reagen' }}</th>
                <th class="center aligned" style="width: 22%">{{ 'Nomor Lot / Batch' }}</th>
                <th class="center aligned" style="width: 22%">{{ 'Tanggal Kadaluarsa' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(test, index) in tests">
                <th class="center aligned" style="vertical-align: middle">
                    {{ `Tes ${index+1}` }}
                </th>

                <td class="center aligned">
                    {{ test.method }}
                </td>

                <td class="center aligned">
                    {{ test.reagen }}
                </td>

                <td class="center aligned">
                    {{ test.batchNumber }}
                </td>

                <td class="center aligned">
                    {{ test.expiredDate }}
                </td>

            </tr>
            </tbody>
        </table>

        <template v-for="(panel, index) in panels" class="ui row">

            <h4 class="ui horizontal divider header">
                {{ `Panel ${index+1}` }}
            </h4>

            <table class="table ui celled">
                <thead>
                <tr>
                    <th style="width: 15%" class="center aligned">{{ 'Tes' }}</th>
                    <th style="width: 15%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                    <th style="width: 15%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                    <th style="width: 15%" class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                    <th style="width: 15%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
                    <th style="width: 25%" class="center aligned">{{ 'Penilaian' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(test, subIndex) in panel.tests">

                    <td class="center aligned">
                        <strong>Tes <span v-for="_ in subIndex + 1">I</span>
                        </strong>
                    </td>

                    <td class="center aligned">
                        {{ test.absPanel }}
                    </td>

                    <td class="center aligned">
                        {{ test.cutPanel }}
                    </td>

                    <td class="center aligned">
                        {{ test.scoPanel }}
                    </td>

                    <td class="center aligned">
                        {{ test.result }}
                    </td>

                    <td>
                        <div class="ui field">
                            <select aria-label="Penilaian" v-model="test.score" class="ui search fluid dropdown" v-on:change="scoreUpdated">
                                <option value="">Penilaian</option>
                                <option v-for="score in options.panelTestScoring" v-bind:key="score.value" v-bind:value="score.value">{{ score.description }}</option>
                            </select>
                        </div>

                        <div class="ui field">
                            <select aria-label="Rujukan Hasil" v-model="test.rightAnswer" class="ui search fluid dropdown" v-on:change="scoreUpdated">
                                <option value="">Rujukan Hasil</option>
                                <option v-for="score in options.rightAnswerScoring" v-bind:key="score.value" v-bind:value="score.value">{{ score.description }}</option>
                            </select>
                        </div>
                    </td>

                </tr>

                <tr>
                    <td colspan="5" class="right aligned"><b>Nilai Kesesuaian Pemeriksaan Panel {{ index + 1 }}</b></td>
                    <td>
                        <div class="ui field">
                            <select aria-label="Kesesuaian" v-model="panel.score" class="ui search fluid dropdown" v-on:change="scoreUpdated">
                                <option value="">Kesesuaian</option>
                                <option v-for="score in options.panelScoring" v-bind:key="score.value" v-bind:value="score.value">{{ score.description }}</option>
                            </select>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

        </template>

        <div class="ui divider"></div>

        <table class="ui table celled">
            <thead>
            <tr>
                <th style="width: 50%" class="center aligned">{{ 'Keterangan' }}</th>
                <th style="width: 50%" class="center aligned">{{ 'Saran' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">
                    {{ submitValue[`keterangan`] }}
                </td>

                <td class="center aligned">
                    {{ submitValue[`saran`] }}
                </td>
            </tr>
            </tbody>
        </table>

        <table class="ui table celled">
            <thead>
            <tr>
                <th style="width: 50%" class="center aligned">{{ 'Nama Pemeriksa' }}</th>
                <th style="width: 50%" class="center aligned">{{ 'Kualifikasi Pemeriksa' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">
                    {{ submitValue[`nama_pemeriksa`] }}
                </td>

                <td class="center aligned">
                    {{ submitValue[`kualifikasi_pemeriksa`] }}
                </td>
            </tr>
            </tbody>
        </table>

        <h4 class="ui horizontal divider header">
            {{ `Hasil Evaluasi` }}
        </h4>

        <table class="ui table celled">
            <thead>
            <tr>
                <th style="width: 50%" class="center aligned">{{ 'Ketepatan Hasil' }}</th>
                <th style="width: 50%" class="center aligned">{{ 'Kesesuaian Strategi' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">
                    {{ avgScore1 }}
                </td>

                <td class="center aligned">
                    {{ avgScore2 }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center aligned">Kategori ketepatan hasil parameter HIV, <b>{{ descScore1 }}</b>. Kategori kesesuaian strategi, <b>{{ descScore2 }}</b>.</td>
            </tr>
            </tbody>
        </table>

        <button class="ui blue button right floated" v-on:click="submitScore">
            <i class="save icon"></i>
            Simpan Penilaian
        </button>

    </div>
</template>

<script>
    export default {
        name: "HIV-123",
        props: ['submit'],
        mounted() {
            console.log(this.submitValue);
            console.log(this.form);
            this.fetchScore();
            $('.ui.dropdown').dropdown({clearable: true});
        },
        computed: {
            submitValue() {
                return JSON.parse(this.submit.value)
            },
            form() {
                return {
                    participant: {
                        number: this.submit.order.invoice.laboratory.participant_number,
                        name: this.submit.order.invoice.laboratory.name,
                        username: this.submit.order.invoice.laboratory.user_id,
                    },
                    date: {
                        received: this.submitValue.tanggal_penerimaan,
                        examination: this.submitValue.tanggal_pemeriskaan,
                    },
                    panels: this.panels,
                }
            },
            tests() {
                return [
                    {
                        method: this.submitValue[`metode_pemeriksaan_tes1`],
                        reagen: this.submitValue[`reagen_tes1`],
                        batchNumber: this.submitValue[`batch_tes1`],
                        expiredDate: this.submitValue[`tanggal_kadaluarsa_tes1`],
                    },
                    {
                        method: this.submitValue[`metode_pemeriksaan_tes2`],
                        reagen: this.submitValue[`reagen_tes2`],
                        batchNumber: this.submitValue[`batch_tes2`],
                        expiredDate: this.submitValue[`tanggal_kadaluarsa_tes2`],
                    },
                    {
                        method: this.submitValue[`metode_pemeriksaan_tes3`],
                        reagen: this.submitValue[`reagen_tes3`],
                        batchNumber: this.submitValue[`batch_tes3`],
                        expiredDate: this.submitValue[`tanggal_kadaluarsa_tes3`],
                    }
                ]
            },
            panels() {
                return [
                    {
                        number: this.submitValue[`kode_panel_0`],
                        quality: this.submitValue[`kualitas_bahan_0`],
                        qualityDescription: this.submitValue[`deskripsi_kualitas_bahan_0`],
                        tests: [
                            {
                                absPanel: this.submitValue[`abs_panel_0_tes_1`],
                                cutPanel: this.submitValue[`cut_panel_0_tes_1`],
                                scoPanel: this.submitValue[`sco_panel_0_tes_1`],
                                result: this.submitValue[`hasil_panel_0_tes_1`],
                                score: null,
                                rightAnswer: null,
                            },
                            {
                                absPanel: this.submitValue[`abs_panel_0_tes_2`],
                                cutPanel: this.submitValue[`cut_panel_0_tes_2`],
                                scoPanel: this.submitValue[`sco_panel_0_tes_2`],
                                result: this.submitValue[`hasil_panel_0_tes_2`],
                                score: null,
                                rightAnswer: null,
                            },
                            {
                                absPanel: this.submitValue[`abs_panel_0_tes_3`],
                                cutPanel: this.submitValue[`cut_panel_0_tes_3`],
                                scoPanel: this.submitValue[`sco_panel_0_tes_3`],
                                result: this.submitValue[`hasil_panel_0_tes_3`],
                                score: null,
                                rightAnswer: null,
                            },
                        ],
                        score: this.score[0].score,
                    },
                    {
                        number: this.submitValue[`kode_panel_1`],
                        quality: this.submitValue[`kualitas_bahan_1`],
                        qualityDescription: this.submitValue[`deskripsi_kualitas_bahan_1`],
                        tests: [
                            {
                                absPanel: this.submitValue[`abs_panel_1_tes_1`],
                                cutPanel: this.submitValue[`cut_panel_1_tes_1`],
                                scoPanel: this.submitValue[`sco_panel_1_tes_1`],
                                result: this.submitValue[`hasil_panel_1_tes_1`],
                                score: null,
                                rightAnswer: null,
                            },
                            {
                                absPanel: this.submitValue[`abs_panel_1_tes_2`],
                                cutPanel: this.submitValue[`cut_panel_1_tes_2`],
                                scoPanel: this.submitValue[`sco_panel_1_tes_2`],
                                result: this.submitValue[`hasil_panel_1_tes_2`],
                                score: null,
                                rightAnswer: null,
                            },
                            {
                                absPanel: this.submitValue[`abs_panel_1_tes_3`],
                                cutPanel: this.submitValue[`cut_panel_1_tes_3`],
                                scoPanel: this.submitValue[`sco_panel_1_tes_3`],
                                result: this.submitValue[`hasil_panel_1_tes_3`],
                                score: null,
                                rightAnswer: null,
                            },
                        ],
                        score: this.score[1].score,
                    },
                    {
                        number: this.submitValue[`kode_panel_2`],
                        quality: this.submitValue[`kualitas_bahan_2`],
                        qualityDescription: this.submitValue[`deskripsi_kualitas_bahan_2`],
                        tests: [
                            {
                                absPanel: this.submitValue[`abs_panel_2_tes_1`],
                                cutPanel: this.submitValue[`cut_panel_2_tes_1`],
                                scoPanel: this.submitValue[`sco_panel_2_tes_1`],
                                result: this.submitValue[`hasil_panel_2_tes_1`],
                                score: null,
                                rightAnswer: null,
                            },
                            {
                                absPanel: this.submitValue[`abs_panel_2_tes_2`],
                                cutPanel: this.submitValue[`cut_panel_2_tes_2`],
                                scoPanel: this.submitValue[`sco_panel_2_tes_2`],
                                result: this.submitValue[`hasil_panel_2_tes_2`],
                                score: null,
                                rightAnswer: null,
                            },
                            {
                                absPanel: this.submitValue[`abs_panel_2_tes_3`],
                                cutPanel: this.submitValue[`cut_panel_2_tes_3`],
                                scoPanel: this.submitValue[`sco_panel_2_tes_3`],
                                result: this.submitValue[`hasil_panel_2_tes_3`],
                                score: null,
                                rightAnswer: null,
                            },
                        ],
                        score: this.score[2].score,
                    },
                ]
            },
            options() {
                return {
                    panelTestScoring: [
                        {
                            value: -1,
                            description: 'Tidak dinilai'
                        },
                        {
                            value: 0,
                            description: 'Tidak Baik (0)'
                        },
                        {
                            value: 4,
                            description: 'Baik (4)'
                        },
                    ],
                    rightAnswerScoring: [
                        {
                            value: 'Reaktif',
                            description: 'Reaktif'
                        },
                        {
                            value: 'Nonreaktif',
                            description: 'Nonreaktif'
                        },
                    ],
                    panelScoring: [
                        {
                            value: -1,
                            description: 'Tidak dinilai'
                        },
                        {
                            value: 0,
                            description: 'Tidak Sesuai (0)'
                        },
                        {
                            value: 5,
                            description: 'Sesuai (5)'
                        },
                    ]
                }
            },
        },
        data() {
            return {
                avgScore1: 0,
                avgScore2: 0,
                descScore1: 'belum selesai dinilai',
                descScore2: 'belum selesai dinilai',
                score: {
                    panels: [
                        {
                            score: null,
                            tests: [
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                            ],
                        },
                        {
                            score: null,
                            tests: [
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                            ],
                        },
                        {
                            score: null,
                            tests: [
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                                {
                                    score: null,
                                    rightAnswer: null,
                                },
                            ],
                        },
                    ]
                }
            }
        },
        methods: {
            scoreUpdated() {
                console.log(this.panels);
                let summarized = this.summarized();
                this.avgScore1 = summarized.avgScore1;
                this.avgScore2 = summarized.avgScore2;
                if (this.avgScore1 < 4) {
                    this.descScore1 = 'tidak baik';
                } else {
                    this.descScore1 = 'baik';
                }
                if (this.avgScore2 < 5) {
                    this.descScore2 = 'tidak sesuai'
                } else {
                    this.descScore2 = 'sesuai'
                }
            },
            summarized() {
                let sumScore1 = 0;
                let sumScore2 = 0;
                let countScore1 = 0;
                let countScore2 = 0;
                for (let i = 0, lenI = this.panels.length; i < lenI; i++) {
                    if (this.panels[i].score != null && this.panels[i].score >= 0) {
                        sumScore2 += this.panels[i].score;
                        countScore2++;
                    }
                    for (let j = 0, lenJ = this.panels[i].tests.length; j < lenJ; j++) {
                        if (this.panels[i].tests[j].score !== null && this.panels[i].tests[j].score >= 0) {
                            sumScore1 += this.panels[i].tests[j].score;
                            countScore1++;
                        }
                    }
                }
                let avgScore1 = 0;
                let avgScore2 = 0;
                if (countScore1 > 0) {
                    avgScore1 = sumScore1 / countScore1;
                }
                if (countScore2 > 0) {
                    avgScore2 = sumScore2 / countScore2;
                }
                return {
                    avgScore1: avgScore1,
                    avgScore2: avgScore2,
                }
            },
            fetchScore() {
                window.axios.get("/v3/scores", {
                    params: {
                        filter: {
                            order_id: this.submit.order_id,
                        },
                        first: true,
                    },
                    paramsSerializer: function (params) {
                        return qs.stringify(params, {encode: false})
                    },
                })
                    .then(response => this.scoreFetched(response.data))
                    .catch(reason => this.failedToFetchScore(reason));
            },
            scoreFetched(score) {
                console.log(score);
                if (score !== null) {
                    //
                }
            },
            failedToFetchScore(reason) {
                console.log(reason.response);
                toastr.error("Gagal memperoleh penilaian");
            },
            submitScore() {
                window.axios.post("/v3/scores", {
                    order_id: this.submit.order_id,
                    value: {
                        data: {
                            panels: this.score,
                        }
                    }
                }).then(response => this.scoreSaved(response.data))
                    .catch(error => this.failedToSaveScore(error));
            },
            scoreSaved(score) {
                console.log(score);
                toastr.success("Nilai tersimpan");
            },
            failedToSaveScore(reason) {
                console.log(reason.response);
                toastr.error("Gagal menyimpan nilai");
            }

        },
    }
</script>

<style scoped>

</style>