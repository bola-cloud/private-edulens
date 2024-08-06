<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\ChargeController;
use App\Http\Controllers\Admin\TransactionsController;
use App\Http\Controllers\Admin\StudentController;

// Front 
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CoursesController;
use App\Http\Controllers\Front\ExamsController;
use App\Http\Controllers\Front\StudentsController;
use App\Http\Controllers\Front\VideoController;
use App\Http\Livewire\Dashboard;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login_jet');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register_jet');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Admin routes
Route::get('/admin', [AuthController::class, 'admin'])->name('admin');

// Grades
Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
Route::get('/grades/create', [GradeController::class, 'create'])->name('grades.create');
Route::post('/grades', [GradeController::class, 'store'])->name('grades.store');
Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');

// Course categories
Route::get('/course_categories', [CourseCategoryController::class, 'index'])->name('course_categories.index');
Route::get('/course_categories/create', [CourseCategoryController::class, 'create'])->name('course_categories.create');
Route::post('/course_categories', [CourseCategoryController::class, 'store'])->name('course_categories.store');
Route::put('/course_categories/{courseCategory}', [CourseCategoryController::class, 'update'])->name('course_categories.update');
Route::delete('/course_categories/{courseCategory}', [CourseCategoryController::class, 'destroy'])->name('course_categories.destroy');

// Courses
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
Route::get('/courses/show/{course}', [CourseController::class, 'show'])->name('courses.show');

// Sections
Route::get('/sections/create/{id}', [SectionController::class, 'create'])->name('sections.create');
Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
Route::get('/sections', [SectionController::class, 'index'])->name('sections.index'); 
Route::get('/sections/edit/{id}', [SectionController::class, 'edit'])->name('sections.edit'); 
Route::put('/sections/{id}', [SectionController::class, 'update'])->name('sections.update'); 
Route::delete('/sections/{id}', [SectionController::class, 'destroy'])->name('sections.destroy');
Route::get('/sections/{id}', [SectionController::class, 'show'])->name('sections.show');

// Media
Route::get('/sections/{section}/media/create', [MediaController::class, 'create'])->name('media.create');
Route::post('/sections/media/create', [MediaController::class, 'store'])->name('media.store');
Route::get('media/{id}/edit', [MediaController::class, 'editMedia'])->name('media.edit');
Route::put('media/{id}/update', [MediaController::class, 'updateMedia'])->name('media.update');
Route::delete('media/{id}/delete', [MediaController::class, 'deleteMedia'])->name('media.destroy');
Route::get('/media/show/{id}', [MediaController::class, 'show'])->name('media.show');

// Exams
Route::get('/sections/{section}/exam/create', [ExamController::class, 'create'])->name('exam.create');
Route::post('/sections/exam/create', [ExamController::class, 'store'])->name('exam.store');
Route::get('exam/{id}/edit', [ExamController::class, 'editExam'])->name('exam.edit');
Route::put('exam/{id}/update', [ExamController::class, 'updateExam'])->name('exam.update');
Route::delete('exam/{id}/delete', [ExamController::class, 'deleteExam'])->name('exam.destroy');
Route::get('/exam/show/{id}', [ExamController::class, 'show'])->name('exam.show');

// Questions
Route::get('/exam/{exam_id}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/exam/{exam_id}/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

// Coupons
Route::get('/coupons', [CouponsController::class, 'index'])->name('coupons.index');
Route::get('/coupons/create', [CouponsController::class, 'create'])->name('coupons.create');
Route::post('/coupons', [CouponsController::class, 'store'])->name('coupons.store');
Route::get('/coupons/apply', [CouponsController::class, 'apply'])->name('coupons.apply');
Route::post('/coupons/applyCoupon', [CouponsController::class, 'applyCoupon'])->name('coupons.applyCoupon');

// Charge wallet
Route::get('/charge', [ChargeController::class, 'index'])->name('charge.index');
Route::post('/charge', [ChargeController::class, 'charge'])->name('charge.charge');

// Transactions
Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');

// Students
Route::resource('students', StudentController::class)->except(['create', 'store', 'show']);

// Welcome route
Route::get('/', function () {
    return view('welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Middleware group for authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/course/content/exam/{exam}', [ExamsController::class, 'exam'])->name('exam_show');
    Route::post('/course/subscribe', [CoursesController::class, 'subscribe'])->name('course_subscribe'); 
    Route::get('/student/profile', [StudentsController::class, 'index'])->name('student-profile'); 
    Route::post('/profile/update', [StudentsController::class, 'update'])->name('profile.update');
    Route::post('/course/content/exam/result/{exam}', [ExamsController::class, 'submitExam'])->name('exam.submit'); 
    Route::get('/course/content/video/{video}', [CoursesController::class, 'video'])->name('video_show');
    Route::get('/video/{id}', [VideoController::class, 'getVideo'])->name('video.get');
});

// Front routes
Route::get('/', [HomeController::class, 'index'])->name('home'); 
Route::get('/courses/{grade}', [HomeController::class, 'courses'])->name('courses'); 
Route::get('/course/content/{course}', [CoursesController::class, 'index'])->name('course_content'); 
Route::get('/exam/{exam}/answers', [ExamsController::class, 'showAnswers'])->name('exam_answers');
// Route::get('/course/content/exam/{exam}', [ExamsController::class, 'exam'])->name('exam_show');  
