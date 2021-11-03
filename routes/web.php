<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Role;
use App\Submit;
use Illuminate\Http\Request;

Route::redirect('/', '/login')->name('homepage');

Route::get('/form', function () {
    return view('form.pnpme-ur');
});

// Route::get('/schedule', function () {
//     return view('schedule');
// });

Route::get('/schedule', 'ScheduleController@index')->name('schedule');

Route::get('/rate', 'RateController@index')->name('rate');

Auth::routes();

Route::prefix('auth')->group(function () {

    Route::prefix('password')->group(function () {

        Route::get('', 'PasswordController@show')->name('auth.change-password.show');

        Route::post('', 'PasswordController@update')->name('auth.change-password.update');

    });

});

Route::post('echo', function (Request $request) {

    return $request->all();

})->name('echo');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::prefix('v1')->group(function () {

    Route::prefix('administrator')->group(function () {

        Route::prefix('contact-person')->group(function () {

            Route::prefix('phone-number')->group(function () {

                Route::post('/', 'v1\Administrator\ContactPersonController@appendPhone')->name('v1.administrator.contact-person.item.append-phone');

                Route::post('/delete', 'v1\Administrator\ContactPersonController@deletePhone')->name('v1.administrator.contact-person.item.delete-phone');

            });

            Route::prefix('reset-password')->group(function () {

                Route::post('/', 'v1\Administrator\ContactPersonController@resetPassword')->name("v1.administrator.contact-person.reset-password");

            });

            Route::get('/', 'v1\Administrator\ContactPersonController@index')->name('v1.administrator.contact-person');

            Route::get('fetch', 'v1\Administrator\ContactPersonController@fetch')->name('v1.administrator.contact-person.fetch');

            Route::post('create', 'v1\Administrator\ContactPersonController@create')->name('v1.administrator.contact-person.create');

            Route::get('{id}', 'v1\Administrator\ContactPersonController@get')->name('v1.administrator.contact-person.item');

            Route::post('{id}', 'v1\Administrator\ContactPersonController@update')->name('v1.administrator.contact-person.item.update');

        });

        Route::prefix('form-input')->group(function () {

            Route::get('/', 'v1\Administrator\FormInputController@index')->name('v1.administrator.form-input');

            Route::post('/send', 'v1\Administrator\FormInputController@send')->name('v1.administrator.form-input.send');

        });

    });

});

Route::prefix('password')->group(function () {

    Route::post('', 'PasswordController@update')->name('password.update');

});

Route::prefix('administrator')->group(function () {

    Route::get('', 'DashboardController@asAdministrator')->name('dashboard.administrator');

    Route::prefix('password')->group(function () {

        Route::get('', 'PasswordController@show')->name('administrator.password.show');

        Route::post('', 'PasswordController@update')->name('administrator.password.update');

    });

    Route::prefix('contact-person')->group(function () {

        Route::get('', 'Administrator\ContactPersonController@index')->name('administrator.contact-person.index');

        Route::get('item', 'Administrator\ContactPersonController@show')->name('administrator.contact-person.show');

        Route::post('login', 'Administrator\ContactPersonController@login')->name('administrator.contact-person.login');

        Route::get('datatable', 'Administrator\ContactPersonController@datatable')->name('administrator.contact-person.datatable');

    });

    Route::prefix('participant')->group(function () {

        Route::get('', 'Administrator\ParticipantController@index')->name('administrator.participant.index');

        Route::get('datatable', 'Administrator\ParticipantController@datatable')->name('administrator.participant.datatable');

    });

    Route::prefix('laboratory')->group(function () {

        Route::get('', 'Administrator\LaboratoryController@index')->name('administrator.laboratory.index');

        Route::get('item', 'Administrator\LaboratoryController@show')->name('administrator.laboratory.show');

        Route::post('update-participant-number/{laboratory}', 'Administrator\LaboratoryController@updateParticipantNumber')->name('administrator.laboratory.update-participant-number');

    });

    Route::prefix('cycle')->group(function () {

        Route::get('', 'Administrator\CycleController@index')->name('administrator.cycle.index');

        Route::get('dataTables', 'v5\CycleController@indexDataTables')->name('administrator.cycle.v5.index-data-tables');

        Route::get('data', 'Administrator\CycleController@indexData')->name('administrator.cycle.index.data');

        Route::get('item', 'Administrator\CycleController@show')->name('administrator.cycle.show');

        Route::post('create', 'v5\CycleController@create')->name('administrator.cycle.create');

        Route::post('update', 'Administrator\CycleController@update')->name('administrator.cycle.update');

        Route::prefix('{cycle}')->group(function () {

            Route::get('package', 'Administrator\CycleController@showPackages')->name('administrator.cycle.package.index');

            Route::prefix('registered')->group(function () {

                Route::get('', 'Administrator\CycleController@registered')->name('administrator.cycle.registered');

                Route::get('data', 'Administrator\CycleController@registeredData')->name('administrator.cycle.registered.data');

            });

            Route::prefix('participant')->group(function () {

                Route::get('', 'Administrator\CycleController@participant')->name('administrator.cycle.participant');

                Route::get('data', 'Administrator\CycleController@participantData')->name('administrator.cycle.participant.data');

                Route::prefix('export')->group(function () {

                    Route::get('', 'Administrator\CycleController@participantExport')->name('administrator.cycle.participant.export');

                    Route::get('data', 'Administrator\CycleController@participantExportData')->name('administrator.cycle.participant.export.data');

                });

            });

            Route::prefix('signature')->group(function () {

                Route::get('', 'Administrator\CycleController@signature')->name('administrator.cycle.signature');

                Route::post('', 'Administrator\CycleController@storeSignature');

            });

            Route::prefix('unpaid')->group(function () {

                Route::get('', 'Administrator\CycleController@showUnpaidOrders')->name('administrator.cycle.unpaid');

            });

            Route::delete('', 'v5\CycleController@delete')->name('administrator.cycle.delete');

        });

        Route::prefix('package')->group(function () {

            Route::get('', 'Administrator\CycleController@showPackage')->name('administrator.cycle.package.show');

            Route::post('update', 'Administrator\CycleController@updatePackage')->name('administrator.cycle.package.update');

            Route::post('create', 'Administrator\CycleController@createPackage')->name('administrator.cycle.package.create');

            Route::prefix('{packageId}')->group(function () {

                Route::get('parameter', 'Administrator\CycleController@showParameters')->name('administrator.cycle.package.parameter.index');

                Route::delete('', 'Administrator\CycleController@deletePackage')->name('administrator.cycle.package.delete');

            });

            Route::prefix('parameter')->group(function () {

                Route::get('', 'Administrator\CycleController@showParameter')->name('administrator.cycle.package.parameter.show');

                Route::post('update', 'Administrator\CycleController@updateParameter')->name('administrator.cycle.package.parameter.update');

                Route::post('create', 'Administrator\CycleController@createParameter')->name('administrator.cycle.package.parameter.create');

                Route::delete('{parameter}', 'Administrator\CycleController@deleteParameter')->name('administrator.cycle.package.parameter.delete');

            });

        });

    });

    Route::prefix('option')->group(function () {

        Route::get('', 'Administrator\OptionController@index')->name('administrator.option.index');

        Route::get('item', 'Administrator\OptionController@show')->name('administrator.option.show');

        Route::post('create', 'Administrator\OptionController@create')->name('administrator.option.create');

        Route::prefix('delete')->group(function () {

            Route::post('{option}', 'Administrator\OptionController@delete')->name('administrator.option.delete');

        });

        Route::post('item', 'Administrator\OptionController@createItem')->name('administrator.option.item.create');

        Route::prefix('table')->group(function () {

            Route::get('item', 'Administrator\OptionController@showTableItem')->name('administrator.option.table.item');

            Route::post('item', 'Administrator\OptionController@updateTableItem')->name('administrator.option.table.item.update');

        });

        Route::prefix('laboratory-type')->group(function () {

            Route::get('', 'Administrator\LaboratoryTypeController@index')->name('administrator.option.laboratory-type.index');

            Route::post('', 'Administrator\LaboratoryTypeController@create')->name('administrator.option.laboratory-type.create');

            Route::get('item', 'Administrator\LaboratoryTypeController@show')->name('administrator.option.laboratory-type.show');

            Route::post('item', 'Administrator\LaboratoryTypeController@update')->name('administrator.option.laboratory-type.update');

        });

    });
// -----------------------------------------------------------------------------------------------------------------------------------------
    Route::prefix('schedule')->group(function () {

        Route::get('', 'Administrator\ScheduleController@index')->name('administrator.schedule.index');
        Route::post('create', 'Administrator\ScheduleController@create')->name('administrator.schedule.create');
        Route::get('edit/{id}','Administrator\ScheduleController@edit')->name('administrator.schedule.edit');;
        Route::post('update','Administrator\ScheduleController@update')->name('administrator.schedule.update');;
        Route::get('hapus/{id}','Administrator\ScheduleController@hapus')->name('administrator.schedule.hapus');;

    });
// ------------------------------------------------------------------------------------------------------------------------------------------

// -----------------------------------------------------------------------------------------------------------------------------------------
    Route::prefix('rate')->group(function () {

        Route::get('', 'Administrator\RateController@index')->name('administrator.rate.index');
        Route::post('create', 'Administrator\RateController@create')->name('administrator.rate.create');
        Route::get('edit/{id}','Administrator\RateController@edit')->name('administrator.rate.edit');;
        Route::post('update','Administrator\RateController@update')->name('administrator.rate.update');;
        Route::get('destroy/{id}','Administrator\RateController@destroy')->name('administrator.rate.destroy');;

    });
// ------------------------------------------------------------------------------------------------------------------------------------------

// -----------------------------------------------------------------------------------------------------------------------------------------
    Route::prefix('news')->group(function () {

        Route::get('', 'Administrator\NewsController@index')->name('administrator.news.index');
        Route::post('create', 'Administrator\NewsController@create')->name('administrator.news.create');
        Route::get('edit/{id}','Administrator\NewsController@edit')->name('administrator.news.edit');;
        Route::post('update','Administrator\NewsController@update')->name('administrator.news.update');;
        Route::get('destroy/{id}','Administrator\NewsController@destroy')->name('administrator.news.destroy');;

    });
// ------------------------------------------------------------------------------------------------------------------------------------------

    Route::prefix('inject')->group(function () {

        Route::get('', 'Administrator\InjectController@index')->name('administrator.inject.index');

        Route::post('', 'Administrator\InjectController@store')->name('administrator.inject.store');

        Route::prefix('{inject}')->group(function () {

            Route::get('', 'Administrator\InjectController@show')->name('administrator.inject.show');

            Route::post('', 'Administrator\InjectController@update')->name('administrator.inject.update');

        });

    });


    Route::prefix('payment')->group(function () {

        Route::get('', 'Administrator\PaymentController@index')->name('administrator.payment.index');

        Route::get('show', 'Administrator\PaymentController@show')->name('administrator.payment.show');

        Route::post('update', 'Administrator\PaymentController@update')->name('administrator.payment.update');

    });

    Route::prefix('submit')->group(function () {

        Route::get('', 'Administrator\SubmitController@index')->name('administrator.submit.index');

        Route::get('show', 'Administrator\SubmitController@show')->name('administrator.submit.show');

        Route::get('preview', 'Administrator\SubmitController@preview')->name('administrator.submit.preview');

        Route::get('show-data', 'Administrator\SubmitController@showSubmitData')->name('administrator.submit.show.data');

        Route::post('save', 'Administrator\SubmitController@save')->name('administrator.submit.save');

        Route::get('print', 'Administrator\SubmitController@print')->name('administrator.submit.print');

        Route::get('download', 'Administrator\SubmitController@download')->name('administrator.submit.download');

    });

    Route::prefix('invoice')->group(function () {

        Route::get('/filter', 'InvoiceController@filterInvoiceByContactPerson')->name('administrator.invoice.filter');

        Route::post('/filter', 'InvoiceController@filterInvoiceByContactPerson')->name('administrator.invoice.filter');

    });

    Route::prefix('payment-confirmation')->group(function () {

        Route::get('/', 'PaymentController@displayList')->name('administrator.payment-confirmation.list');

        Route::get('/{id}', 'PaymentController@displayItem')->name('administrator.payment-confirmation.item');

        Route::post('/{id}/verify', 'PaymentController@verifyItem')->name('administrator.payment-confirmation.verify');

    });

    Route::prefix('instructions')->group(function () {

        Route::get('/', 'InstructionController@displayAsAdministrator')->name('administrator.instruction.display');

    });

    Route::prefix('form-input')->group(function () {

        Route::get('/{id}', 'FormController@inputByAdministrator')->name('administrator.form-input');

        Route::prefix('/proceed')->group(function () {

            Route::post('{order_package_id}', 'FormController@proceedByAdmin')->name('administrator.form.proceed');

            Route::post('mikrobiologi-malaria/{order_package_id}', 'FormController@proceedMikrobiologiMalariaFormByAdmin')->name('administrator.proceed.cycle1.mikrobiologi-malaria');

        });

    });

    Route::prefix('certificates')->group(function () {

        Route::get('/', 'Administrator\CertificateController@index')->name('administrator.certificate.index');

        Route::get('datatable', 'Administrator\CertificateController@datatable')->name('administrator.certificate.datatable');

        Route::get('show', 'Administrator\CertificateController@show')->name('administrator.certificate.show');

    });

    Route::prefix('preview')->group(function () {

        Route::get('/{id}', 'FormController@showPreviewByaAdministrator')->name('administrator.preview');

    });

    Route::prefix('export')->group(function () {

        Route::prefix('participant')->group(function () {

            Route::get('/', 'ExporterController@exportParticipants')->name('administrator.export.participant');

        });

    });

    Route::prefix('survey')->group(function () {

        Route::get('/', 'SurveyController@defaultSurvey')->name('administrator.survey.default');

        Route::get('/{id}', 'SurveyController@index')->name('administrator.survey.index');

    });

});

Route::prefix('superadmin')->group(function () {

    Route::prefix('account')->group(function () {

        Route::get('/', 'v1\Administrator\AccountController@index')->name('superadmin.account.index');

        Route::get('fetch', 'v1\Administrator\AccountController@fetch')->name('superadmin.account.fetch');

    });

});

Route::prefix('participant')->group(function () {

    Route::get('', 'DashboardController@asParticipant')->name('dashboard.participant');

    Route::prefix('profile')->group(function () {

        Route::get('', 'Participant\ProfileController@show')->name('participant.profile.show');

        Route::post('', 'Participant\ProfileController@update')->name('participant.profile.update');

    });

    Route::prefix('laboratory')->group(function () {

        Route::get('', 'Participant\LaboratoryController@index')->name('participant.laboratory.index');

        Route::get('item', 'Participant\LaboratoryController@show')->name('participant.laboratory.show');

        Route::post('item', 'Participant\LaboratoryController@update')->name('participant.laboratory.update');

    });

    Route::prefix('password')->group(function () {

        Route::get('', 'PasswordController@show')->name('participant.password.show');

        Route::post('', 'PasswordController@update')->name('participant.password.update');

    });

    Route::prefix('invoice')->group(function () {

        Route::get('', 'Participant\InvoiceController@index')->name('participant.invoice.index');

        Route::get('item', 'Participant\InvoiceController@show')->name('participant.invoice.show');

        Route::get('create', 'Participant\InvoiceController@showCreateForm')->name('participant.invoice.show-create-form');

        Route::post('create', 'Participant\InvoiceController@create')->name('participant.invoice.create');

        Route::post('cancel', 'Participant\InvoiceController@cancel')->name('participant.invoice.cancel');

    });

    Route::prefix('payment')->group(function () {

        Route::get('', 'Participant\PaymentController@index')->name('participant.payment.index');

        Route::get('create', 'Participant\PaymentController@showCreateForm')->name('participant.payment.show-create-form');

        Route::post('create', 'Participant\PaymentController@create')->name('participant.payment.create');

        Route::get('item', 'Participant\PaymentController@show')->name('participant.payment.show');

    });

    Route::prefix('submit')->group(function () {

        Route::get('', 'Participant\SubmitController@index')->name('participant.submit.index');

        Route::get('schedule', 'Participant\SubmitController@schedule')->name('participant.submit.schedule');

        Route::get('item', 'Participant\SubmitController@show')->name('participant.submit.show');

        Route::post('save', 'Participant\SubmitController@save')->name('participant.submit.save');

        Route::get('preview', 'Participant\SubmitController@preview')->name('participant.submit.preview');

        Route::get('print', 'Participant\SubmitController@print')->name('participant.submit.print');

        Route::get('download', 'Participant\SubmitController@download')->name('participant.submit.download');

    });

    Route::prefix('report')->group(function () {

        Route::get('', 'Participant\ReportController@index')->name('participant.report.index');

    });

    Route::prefix('certificate')->group(function () {

        Route::get('', 'Participant\CertificateController@index')->name('participant.certificate.index');

    });

    Route::prefix('survey')->group(function () {

        Route::get('', 'Participant\SurveyController@index')->name('participant.survey.index');

    });

    Route::prefix('schedule')->group(function () {

        Route::get('', 'Participant\ScheduleController@index')->name('participant.schedule.index');

    });

    Route::prefix('rate')->group(function () {

        Route::get('', 'Participant\RateController@index')->name('participant.rate.index');

    });

    Route::prefix('news')->group(function () {

        Route::get('show', 'Participant\NewsController@show')->name('participant.news.show');

    });

});

Route::prefix('research')->group(function () {

    Route::get('find-alg', 'ResearchController@findAlg')->name('research.find-alg.show');

    Route::post('find-alg', 'ResearchController@findAlgSubmit')->name('research.find-alg.submit');

    Route::get('export/{package_id}', 'v1\Installation\ScoringController@export');

});

Route::prefix('instalasi')->group(function () {

    Route::get('', 'Installation\DashboardController@index')->name('installation.home');

    Route::prefix('submit')->group(function () {

        Route::get('', 'Installation\SubmitController@index')->name('installation.submit.index');

        Route::get('datatable', 'Installation\SubmitController@datatable')->name('installation.submit.datatable');

        Route::get('show', 'Installation\SubmitController@show')->name('installation.submit.show');

        Route::get('print', 'Installation\SubmitController@print')->name('installation.submit.print');

        Route::get('download', 'Installation\SubmitController@download')->name('installation.submit.download');

    });

    Route::prefix('scoring')->group(function () {

        Route::get('', 'Installation\ScoringController@index')->name('installation.scoring.index');

        Route::post('', 'Installation\ScoringController@store')->name('installation.scoring.store');

        Route::get('datatable', 'Installation\ScoringController@datatable')->name('installation.scoring.datatable');

        Route::get('show', 'Installation\ScoringController@show')->name('installation.scoring.show');

        Route::post('calculate', 'Installation\ScoringController@autoCalculate')->name('installation.scoring.auto-calculate');

    });

    Route::prefix('submit-null')->group(function () {

        Route::get('', 'Installation\SubmitController@indexNull')->name('installation.submit.index-null');

        Route::get('datatable', 'Installation\SubmitController@datatableNull')->name('installation.submit.datatable-null');

    });

    Route::prefix('score')->group(function () {

        Route::get('', 'Installation\ScoreController@index')->name('installation.score.index');

        Route::get('datatable', 'Installation\ScoreController@datatable')->name('installation.score.datatable');

        Route::get('show', 'Installation\ScoreController@show')->name('installation.score.show');

    });

    Route::prefix('certificate')->group(function () {

        Route::get('', 'Installation\CertificateController@index')->name('installation.certificate.index');

    });

    Route::prefix('statistic')->group(function () {

        Route::get('', 'Installation\StatisticController@index')->name('installation.statistic.index');

    });

    Route::prefix('rekap-isian')->group(function () {

        Route::get('', 'Installation\RekapIsianController@index')->name('installation.rekap-isian.index');

    });

});

Route::prefix(Role::ROLE_DIVISION_IMMUNOLOGY_PATH)->group(function () {

    Route::get('', 'Division\Immunology\DashboardController@show')->name('division.immunology.home');

    Route::prefix('password')->group(function () {

        Route::get('', 'PasswordController@show')->name('division.immunology.password.show');

        Route::post('', 'PasswordController@update')->name('division.immunology.password.update');

    });

    Route::prefix('cycle')->group(function () {

        Route::get('', 'Division\Common\CycleController@index')->name('division.immunology.cycle.index');

        Route::get('{id}', 'Division\Common\PackageController@index')->name('division.immunology.cycle.package.index');

    });

    Route::prefix('parameter')->group(function () {

        Route::get('', 'Division\Immunology\ParameterController@showStatistic')->name('division.immunology.parameter.statistic');

    });

});

Route::prefix(Role::ROLE_DIVISION_HEALTH_CHEMICAL_PATH)->group(function () {

    Route::get('', 'Division\HealthChemical\DashboardController@show')->name('division.health-chemical.home');

    Route::prefix('password')->group(function () {

        Route::get('', 'PasswordController@show')->name('division.health-chemical.password.show');

        Route::post('', 'PasswordController@update')->name('division.health-chemical.password.update');

    });

    Route::prefix('cycle')->group(function () {

        Route::get('', 'Division\Common\CycleController@index')->name('division.health-chemical.cycle.index');

        Route::get('{id}', 'Division\Common\PackageController@index')->name('division.health-chemical.cycle.package.index');

    });

    Route::prefix('parameter')->group(function () {

        Route::get('', 'Division\HealthChemical\ParameterController@showStatistic')->name('division.health-chemical.parameter.statistic');

    });

});

Route::prefix(Role::ROLE_DIVISION_MICROBIOLOGY_PATH)->group(function () {

    Route::get('', 'Division\Microbiology\DashboardController@show')->name('division.microbiology.home');

    Route::prefix('password')->group(function () {

        Route::get('', 'PasswordController@show')->name('division.microbiology.password.show');

        Route::post('', 'PasswordController@update')->name('division.microbiology.password.update');

    });

    Route::prefix('cycle')->group(function () {

        Route::get('', 'Division\Common\CycleController@index')->name('division.microbiology.cycle.index');

        Route::get('{id}', 'Division\Common\PackageController@index')->name('division.microbiology.cycle.package.index');

    });

    Route::prefix('parameter')->group(function () {

        Route::get('', 'Division\Microbiology\ParameterController@showStatistic')->name('division.microbiology.parameter.statistic');

    });

});

Route::prefix(Role::ROLE_DIVISION_PATHOLOGY_PATH)->group(function () {

    Route::get('', 'Division\Pathology\DashboardController@show')->name('division.pathology.home');

    Route::prefix('password')->group(function () {

        Route::get('', 'PasswordController@show')->name('division.pathology.password.show');

        Route::post('', 'PasswordController@update')->name('division.pathology.password.update');

    });

    Route::prefix('cycle')->group(function () {

        Route::get('', 'Division\Common\CycleController@index')->name('division.pathology.cycle.index');

        Route::get('{id}', 'Division\Common\PackageController@index')->name('division.pathology.cycle.package.index');

    });

    Route::prefix('parameter')->group(function () {

        Route::get('', 'Division\Pathology\ParameterController@showStatistic')->name('division.pathology.parameter.statistic');

    });

});

Route::prefix('statistic-redirect')->group(function () {

    Route::prefix('by-parameter')->group(function () {

        Route::get('', 'Division\Common\StatisticController@byParameter')->name('statistic-redirect.by-parameter');

    });

});

Route::resource('submits', 'SubmitController');

Route::prefix('v3')->group(function () {

    Route::resource('cycles', 'v3\CycleController');

    Route::resource('divisions', 'v3\DivisionController');

    Route::resource('invoices', 'v3\InvoiceController');

    Route::resource('laboratories', 'v3\LaboratoryController');

    Route::resource('orders', 'v3\OrderController');

    Route::resource('packages', 'v3\PackageController');

    Route::resource('submits', 'v3\SubmitController');

    Route::resource('scores', 'v3\ScoreController');

});

Route::prefix('vue')->group(function () {

    Route::prefix('password')->group(function () {

        Route::post('update', 'v3\PasswordController@update');

    });

});

