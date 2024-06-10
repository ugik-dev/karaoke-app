<?php

use App\Http\Controllers\AccountCodeController;
use App\Http\Controllers\AccountCodeReceptionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityRecapController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetItemController;
use App\Http\Controllers\BankLaguController;
use App\Http\Controllers\BudgetImplementationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailedFAReportController;
use App\Http\Controllers\DipaController;
use App\Http\Controllers\ExpenditureUnitController;
use App\Http\Controllers\IkskController;
use App\Http\Controllers\InstitutionalBudgetController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\PaymentReceiptController;
use App\Http\Controllers\PaymentVerificationController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PerformanceIndicatorController;
use App\Http\Controllers\PPKController;
use App\Http\Controllers\ProgramTargetController;
use App\Http\Controllers\ReceiptActionController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\RuhPaymentController;
use App\Http\Controllers\SBMSBIController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\UnitBudgetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificatorController;
use App\Http\Controllers\WithdrawalPlanController;
use App\Http\Controllers\WorkUnitController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/login')->with('success', 'Data email berhasil diverifikasi.');
})->middleware(['auth'])->name('verification.verify');

Route::middleware(['auth'])->group(function () {
    Route::get('app', [DashboardController::class, 'app'])->name('app');
    Route::get('app/search-music', [DashboardController::class, 'search'])->name('app.search-music');
    Route::get('app/play/{music}', [DashboardController::class, 'play'])->name('app.play');
});
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Mendefinisikan route resource dengan penyesuaian nama
    Route::resource('profile', MyProfileController::class)->names([
        'index' => 'my-profile.index',
        'update' => 'my-profile.update',
    ]);

    Route::get('notification/test', [NotificationController::class, 'test'])->name('notification.test');

    Route::prefix('bank-lagu')->group(function () {
        Route::get('/', [BankLaguController::class, 'index'])->name('bank-lagu.index');
        Route::post('/create', [BankLaguController::class, 'store'])->name('bank-lagu.store');
        Route::post('/update', [BankLaguController::class, 'update'])->name('bank-lagu.update');
        Route::delete('delete/{accountCode}', [BankLaguController::class, 'destroy'])->name('bank-lagu.delete');
        Route::get('/scan', [BankLaguController::class, 'scan'])->name('bank-lagu.scan');
        // Route::post('adm-penerimaan/kode-akun', [AccountCodeReceptionController::class, 'store'])->name('account_code_reception.store');
        // Route::patch('adm-penerimaan/kode-akun/{accountCodeReception}/update', [AccountCodeReceptionController::class, 'update'])->name('account_code_reception.update');
        // Route::delete('adm-penerimaan/kode-akun/{accountCodeReception}/hapus', [AccountCodeReceptionController::class, 'destroy'])->name('account_code_reception.delete');
        // Route::get('/download-account-code-reception-pdf', [AccountCodeReceptionController::class, 'downloadAccountCodeReceptionPdf'])->name('download.account.code.reception.pdf');
    });

    Route::prefix('renstra')->group(function () {
        Route::get('visi', [RenstraController::class, 'vision'])->name('vision.index');
        Route::patch('edit-visi', [RenstraController::class, 'updateVision'])->name('vision.update');
        Route::get('misi', [RenstraController::class, 'mission'])->name('mission.index');
        Route::post('tambah-misi', [RenstraController::class, 'storeMission'])->name('mission.store');
        Route::post('update-misi', [RenstraController::class, 'updateMission'])->name('mission.update');
        Route::post('hapus-misi', [RenstraController::class, 'deleteMission'])->name('mission.delete');
        Route::get('/download-misi-pdf', [RenstraController::class, 'downloadMissionPdf'])->name('download.mission.pdf');
        Route::get('/download-mission-excel', [RenstraController::class, 'downloadMissionExcel'])->name('download.mission.excel');
        Route::get('iku', [RenstraController::class, 'iku'])->name('iku.index');
        Route::patch('/iku/{iku}/update', [RenstraController::class, 'updateIku'])->name('iku.update');
        Route::get('/download-iku-pdf', [RenstraController::class, 'downloadIkuPdf'])->name('download.iku.pdf');
        Route::get('/download-iku-excel', [RenstraController::class, 'downloadIkuExcel'])->name('download.iku.excel');
        Route::post('tambah-iku', [RenstraController::class, 'storeIku'])->name('iku.store');
        Route::post('hapus-iku', [RenstraController::class, 'deleteIku'])->name('iku.delete');
    });
    Route::prefix('perkin')->group(function () {
        Route::get('iksp', [ProgramTargetController::class, 'index'])->name('program_target.index');
        Route::post('iksp', [ProgramTargetController::class, 'store'])->name('program_target.store');
        Route::delete('iksp/{programTarget}/hapus', [ProgramTargetController::class, 'destroy'])->name('program_target.delete');
        Route::patch('iksp/{programTarget}/update', [ProgramTargetController::class, 'update'])->name('program_target.update');
        Route::get('/download-iksp-pdf', [ProgramTargetController::class, 'downloadIkspPdf'])->name('download.iksp.pdf');
        Route::get('sasaran-kegiatan', [PerformanceIndicatorController::class, 'index'])->name('performance_indicator.index');
        Route::post('sasaran-kegiatan', [PerformanceIndicatorController::class, 'store'])->name('performance_indicator.store');
        Route::delete('sasaran-kegiatan/{performanceIndicator}/hapus', [PerformanceIndicatorController::class, 'destroy'])->name('performance_indicator.delete');
        Route::patch('sasaran-kegiatan/{performanceIndicator}/update', [PerformanceIndicatorController::class, 'update'])->name('performance_indicator.update');
        Route::get('/download-performance-indicators-pdf', [PerformanceIndicatorController::class, 'downloadPerformanceIndicatorPdf'])->name('download.performance-indicator.pdf');
        Route::get('/download-performance-indicators-excel', [PerformanceIndicatorController::class, 'downloadPerformanceIndicatorExcel'])->name('download.performance-indicator.excel');
        Route::get('iksk', [IkskController::class, 'index'])->name('iksk.index');
        Route::post('iksk', [IkskController::class, 'store'])->name('iksk.store');
        Route::delete('iksk/{iksk}/hapus', [IkskController::class, 'destroy'])->name('iksk.delete');
        Route::patch('iksk/{iksk}/update', [IkskController::class, 'update'])->name('iksk.update');
        Route::get('/download-iksk-pdf', [IkskController::class, 'downloadIkskPdf'])->name('download.iksk.pdf');
        Route::get('/download-iksk-excel', [PerformanceIndicatorController::class, 'downloadPerformanceIndicatorExcel'])->name('download.iksk.excel');
    });
    Route::prefix('pengaturan')->group(function () {
        Route::get('unit-kerja', [WorkUnitController::class, 'index'])->name('work_unit.index');
        Route::post('unit-kerja', [WorkUnitController::class, 'store'])->name('work_unit.store');
        Route::patch('unit-kerja/{workUnit}/update', [WorkUnitController::class, 'update'])->name('work_unit.update');
        Route::delete('unit-kerja/{workUnit}/hapus', [WorkUnitController::class, 'destroy'])->name('work_unit.delete');
        Route::get('/download-work-unit-pdf', [WorkUnitController::class, 'downloadWorkUnitPdf'])->name('download.workunit.pdf');
        Route::get('satuan-belanja', [ExpenditureUnitController::class, 'index'])->name('expenditure_unit.index');
        Route::post('satuan-belanja', [ExpenditureUnitController::class, 'store'])->name('expenditure_unit.store');
        Route::patch('satuan-belanja/{expenditureUnit}/update', [ExpenditureUnitController::class, 'update'])->name('expenditure_unit.update');
        Route::delete('satuan-belanja/{expenditureUnit}/hapus', [ExpenditureUnitController::class, 'destroy'])->name('expenditure_unit.delete');
        Route::get('/download-expenditure-unit-pdf', [ExpenditureUnitController::class, 'downloadExpenditureUnitPdf'])->name('download.expenditure.unit.pdf');
        Route::get('sbm-sbi', [SBMSBIController::class, 'index'])->name('sbm_sbi.index');
        Route::post('sbm-sbi', [SBMSBIController::class, 'store'])->name('sbm_sbi.store');
        Route::get('pagu', [InstitutionalBudgetController::class, 'index'])->name('pagu.index');
        Route::get('pagu-lembaga', [InstitutionalBudgetController::class, 'index'])->name('ins_budget.index');
        Route::post('pagu-lembaga', [InstitutionalBudgetController::class, 'store'])->name('ins_budget.store');
        Route::get('pagu/unit/{year}', [UnitBudgetController::class, 'index'])->name('unit_budget.index');
        Route::post('pagu-unit', [UnitBudgetController::class, 'store'])->name('unit_budget.store');
        Route::get('/download-pagu-pdf', [InstitutionalBudgetController::class, 'downloadPaguPdf'])->name('download.pagu.pdf');
        Route::get('kelola-user', [UserController::class, 'index'])->name('user.index');
        Route::post('user', [UserController::class, 'store'])->name('user.store')->middleware('can:create user');
        Route::post('user/{user}/resend-mail', [UserController::class, 'resendEmail'])->name('user.resend-mail');
        Route::patch('user/{user}/update', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/{user}/hapus', [UserController::class, 'destroy'])->name('user.delete');
        Route::get('/download-user-pdf', [UserController::class, 'downloadUserPdf'])->name('download.user.pdf');


        Route::resource('bendahara', TreasurerController::class)->names([
            'index' => 'treasurer.index',
            'store' => 'treasurer.store',
            'update' => 'treasurer.update',
            'destroy' => 'treasurer.destroy',
        ])->parameters([
            'bendahara' => 'treasurer',
        ]);

        Route::resource('timeline', TimelineController::class)->names([
            'index' => 'timeline.index',
            'store' => 'timeline.store',
            'destroy' => 'timeline.destroy',
        ]);
        Route::post('timeline/store_update', [TimelineController::class, 'store_update'])->name('timeline.store_update');
        Route::get('timeline/rekap/{timeline}', [TimelineController::class, 'rekap'])->name('timeline.rekap');

        // PPK Routes
        Route::resource('ppk', PPKController::class);

        Route::resource('verifikator', VerificatorController::class)->names([
            'index' => 'verificator.index',
            'store' => 'verificator.store',
            'update' => 'verificator.update',
            'destroy' => 'verificator.destroy',
        ])->parameters([
            'verifikator' => 'verificator', // Replace 'custom_param' with your desired parameter name
        ]);

        // Asset Item Routes
        Route::resource('barang-aset', AssetItemController::class)->names([
            'index' => 'asset_item.index',
            'store' => 'asset_item.store',
            'update' => 'asset_item.update',
            'destroy' => 'asset_item.destroy',
        ])->parameters([
            'barang-aset' => 'assetItem', // Replace 'custom_param' with your desired parameter name
        ]);
    });
    Route::prefix('codeAccount')->group(function () {
        Route::get('kode-akun', [AccountCodeController::class, 'index'])->name('account_code.index');
        Route::post('kode-akun', [AccountCodeController::class, 'store'])->name('account_code.store');
        Route::patch('kode-akun/{accountCode}/update', [AccountCodeController::class, 'update'])->name('account_code.update');
        Route::delete('kode-akun/{accountCode}/hapus', [AccountCodeController::class, 'destroy'])->name('account_code.delete');
        Route::get('/download-account-code-pdf', [AccountCodeController::class, 'downloadAccountCodePdf'])->name('download.account.code.pdf');
        Route::get('adm-penerimaan/kode-akun', [AccountCodeReceptionController::class, 'index'])->name('account_code_reception.index');
        Route::post('adm-penerimaan/kode-akun', [AccountCodeReceptionController::class, 'store'])->name('account_code_reception.store');
        Route::patch('adm-penerimaan/kode-akun/{accountCodeReception}/update', [AccountCodeReceptionController::class, 'update'])->name('account_code_reception.update');
        Route::delete('adm-penerimaan/kode-akun/{accountCodeReception}/hapus', [AccountCodeReceptionController::class, 'destroy'])->name('account_code_reception.delete');
        Route::get('/download-account-code-reception-pdf', [AccountCodeReceptionController::class, 'downloadAccountCodeReceptionPdf'])->name('download.account.code.reception.pdf');
    });
    Route::prefix('penganggaran')->group(function () {
        Route::get('dipa/log/{dipa}', [DipaController::class, 'log'])->name('dipa.log');
        Route::get('rekap', [DipaController::class, 'rekap'])->name('dipa.rekap');
        Route::get('rekap/{dipa}', [DipaController::class, 'review_rekap'])->name('dipa.review-rekap');
        Route::get('permohonan-approval', [DipaController::class, 'approval'])->name('dipa.approval');
        Route::get('permohonan-approval/{dipa}', [DipaController::class, 'review'])->name('dipa.review');
        Route::get('permohonan-approval/pdf/{dipa}', [DipaController::class, 'pdf'])->name('dipa.pdf');
        Route::get('permohonan-approval/fpdf/{dipa}', [PDFController::class, 'dipa'])->name('dipa.fpdf');
        Route::get('permohonan-approval/cetak/{dipa}', [PDFController::class, 'cetak'])->name('dipa.cetak');
        Route::get('permohonan-approval/cetak-mapping/{dipa}', [PDFController::class, 'cetak_mapping'])->name('dipa.cetak-mapping');
        Route::post('dipa/ajukan/{dipa}', [DipaController::class, 'ajukan'])->name('dipa.ajukan');
        Route::post('dipa/approval/kpa/{dipa}', [DipaController::class, 'approval_kpa'])->name('dipa-action.kpa');
        Route::post('dipa/approval/ka/{dipa}', [DipaController::class, 'approval_kp'])->name('dipa-action.ka');
        Route::post('dipa/approval/ppk/{dipa}', [DipaController::class, 'approval_ppk'])->name('dipa-action.ppk');
        Route::post('dipa/approval/spi/{dipa}', [DipaController::class, 'approval_spi'])->name('dipa-action.spi');
        Route::post('dipa/approval/add-note', [ActivityController::class, 'add_note'])->name('dipa-action.add_note');
        Route::post('dipa/approval/perencanaan/{dipa}', [DipaController::class, 'approval_perencanaan'])->name('dipa-action.perencanaan');
        Route::post('dipa/approval/release/{dipa}', [DipaController::class, 'approval_release'])->name('dipa-action.release');
        Route::post('delete-dipa', [BudgetImplementationController::class, 'delete_dipa'])->name('dipa.delete');


        Route::get('dipa/create/{timeline}', [BudgetImplementationController::class, 'create'])->name('budget_implementation.create');
        Route::get('dipa/buat-revisi/{dipa}', [BudgetImplementationController::class, 'create_copy'])->name('dipa.create-revisi');
        Route::get('dipa', [BudgetImplementationController::class, 'index'])->name('budget_implementation.index');
        Route::get('dipa/{dipa}', [BudgetImplementationController::class, 'dipa'])->name('budget_implementation.dipa');
        Route::post('dipa', [BudgetImplementationController::class, 'store'])->name('budget_implementation.store');
        Route::post('edit-dipa', [BudgetImplementationController::class, 'update'])->name('budget_implementation.update');
        Route::post('dipa/{dipa}', [BudgetImplementationController::class, 'update_dipa'])->name('dipa.update');
        Route::delete('hapus-dipa/{type}/{id}', [BudgetImplementationController::class, 'destroy'])->name('budget_implementation.delete');
        Route::get('rekap-kegiatan-dan-upload-data-dukung', [ActivityRecapController::class, 'index'])->name('activity_recap.index');
        Route::get('rekap-kegiatan-dan-upload-data-dukung/{dipa}', [ActivityRecapController::class, 'open'])->name('activity_recap.open');
        Route::post('rekap-kegiatan-dan-upload-data-dukung', [ActivityRecapController::class, 'store'])->name('activity_recap.store');
        Route::get('rekap-kegiatan/bukti-dukung/{activityRecap}', [ActivityRecapController::class, 'showFile'])
            ->name('activity-recap.show-file');
        Route::post('rekap-kegiatan-dan-upload-data-dukung/update-status', [ActivityRecapController::class, 'updateStatus'])->name('activity_recap.update_status');
        Route::get('rencana-penarikan-dana', [WithdrawalPlanController::class, 'index'])->name('withdrawal_plan.index');
        Route::get('rencana-penarikan-dana/{dipa}', [WithdrawalPlanController::class, 'open'])->name('withdrawal_plan.open');
        Route::post('rencana-penarikan-dana', [WithdrawalPlanController::class, 'store'])->name('withdrawal_plan.store');
        Route::post('rencana-penarikan-dana-update', [WithdrawalPlanController::class, 'update'])->name('withdrawal_plan.update');
    });
    Route::prefix('pembayaran')->group(function () {
        Route::get('ruh-pembayaran', [RuhPaymentController::class, 'index'])->name('ruh_payment.index');
    });
    Route::prefix('penerimaan')->group(function () {
        Route::get('rekam-penerimaan', [ReceptionController::class, 'index'])->name('reception.index');
        Route::post('rekam-penerimaan', [ReceptionController::class, 'store'])->name('reception.store');
        Route::patch('rekam-penerimaan/{reception}/update', [ReceptionController::class, 'update'])->name('reception.update');
        Route::delete('rekam-penerimaan/{reception}/hapus', [ReceptionController::class, 'destroy'])->name('reception.delete');
        Route::delete('rekam-penerimaan/{reception}/hapus-beberapa', [ReceptionController::class, 'deleteSome'])->name('reception.deleteSome');
    });
    Route::prefix('aset')->group(function () {
        // Asset
        Route::resource('rekam-aset', AssetController::class)->names([
            'index' => 'asset.index',
            'store' => 'asset.store',
            'destroy' => 'asset.destroy',
            'edit', 'asset.edit',
        ])->parameters([
            'rekam-aset' => 'asset', // Replace 'custom_param' with your desired parameter name
        ]);
    });

    Route::prefix('ruh-pembayaran')->group(function () {
        Route::resource('rekam-kuitansi', PaymentReceiptController::class)->parameters([
            'rekam-kuitansi' => 'receipt',
        ])->names([
            'index' => 'payment-receipt.index',
            'store' => 'payment-receipt.store',
            'update' => 'payment-receipt.update',
            'destroy' => 'payment-receipt.destroy',
        ]);
        Route::get('rekam-kuitansi/berkas/{receipt}', [ReceiptController::class, 'showFile'])
            ->name('receipt.show-file');
        Route::get('rekam-kuitansi/print-kwitansi/{receipt}', [PaymentReceiptController::class, 'print_kwitansi'])->name('payment-receipt.print-kwitansi');
        Route::get('rekam-kuitansi/print-rampung/{receipt}', [PaymentReceiptController::class, 'print_rampung'])->name('payment-receipt.print-rampung');
        Route::get('rekam-kuitansi/print-tiket/{receipt}/{verif?}', [PaymentReceiptController::class, 'print_ticket'])->name('payment-receipt.print-ticket');
        Route::get('kuitansi/detail/{receipt}', [PaymentReceiptController::class, 'detail'])->name('payment-receipt.detail');
        Route::get('kuitansi/', [PaymentReceiptController::class, 'list'])->name('payment-receipt.list');

        Route::prefix('receipt-action/{receipt}')->name('receipt-action.')->controller(ReceiptActionController::class)->group(function () {
            Route::post('upload-berkas', 'upload_berkas')->name('upload-berkas');
            Route::post('ajukan', 'ajukan')->name('ajukan');
            Route::post('change-status-money', 'change_money_app')->name('change-status-money-app');
            Route::post('update-rampung', 'update_ramppung')->name('update-rampung');
            Route::post('verification', 'verification')->name('verification');
            Route::post('spi', 'spi')->name('spi');
            Route::post('ppk', 'ppk')->name('ppk');
            Route::post('treasurer', 'treasurer')->name('treasurer');
            // Route::post('ppk', [ReceptionController::class, 'ppk'])->name('ppk');
        });

        Route::resource('rekam-verifikasi', PaymentVerificationController::class)->parameters([
            'rekam-verifikasi' => 'payment_verification',
        ])->names([
            'index' => 'payment-verification.index',
            'store' => 'payment-verification.store',
            'update' => 'payment-verification.update',
            'destroy' => 'payment-verification.destroy',
        ]);
    });
    Route::prefix('cetak-laporan')->group(function () {
        Route::get('laporan-fa-detail', [DetailedFAReportController::class, 'index'])->name('detailed-FA-report.index');
        Route::get('laporan-fa-detail-excel/{dipa}', [DetailedFAReportController::class, 'excel'])->name('detailed-FA-report.excel');
    });
});
