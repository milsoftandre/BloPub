<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\Sendmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function resetindex()
    {
        return view('auth.reset');
    }

    public function reset(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required',
                function ($attribute, $value, $fail) use ($request) {

                    if (@Employee::where('email',$request->email)->first()->status!=0) {
                        $fail('Пользователь заблокирован');
                    }
                }],

        ]);
        $pwd = rand(999909,9999999999);
        $emp = Employee::where('email',$request->email)->first()->id;
        Employee::find($emp)->update([
            'password' => bcrypt($pwd)
        ]);

        $details = [
            'title' => 'Новый пароль | New password',
            'body' => 'Новый пароль: '.$pwd.'<br> New password: '.$pwd
        ];

        if(strpos($request->email,"@")) {
            Mail::to($request->email)->send(new Sendmail($details));
        }


        return redirect("reset")->with('success','На ваш прочтовый адрес отправлен новый пароль');
    }

    public function customLogin(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required',
                function ($attribute, $value, $fail) use ($request) {

                    if (@Employee::where('email',$request->email)->first()->status!=0) {
                        $fail('Пользователь заблокирован');
                    }
                }],
            'password' => ['required'],

//            'code' => [
//                'required',
//                function ($attribute, $value, $fail) use ($request) {
//
//                    if (@Employee::where('email',$request->email)->first()->code!=$value) {
//                        $fail('Не верный код');
//                    }
//                },
//            ],
        ]);
        //route('tasks.index')
        if (Auth::attempt($credentials)) {
            if(Auth::user()->lang) {
                $locale = Auth::user()->lang;
                    session(['locale' => $locale]);
                App::setLocale($locale);
            }
            return redirect()->intended('/tasks')
                ->withSuccess('Signed in');

        }

        return redirect("login")->with('success','Не верный логин, пароль или код из СМС');
    }

    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }

    public function getcode(Request $request)
    {
       /// Employee::where('email', $request->email)->update(['code' => 123]); exit;
        $code = rand(1111,9999);
        if(@Employee::where('email',$request->email)->first()->tel) {

            file_get_contents('https://smsc.ru/sys/send.php?login=Ruslanzhmak&psw=Qwerdfqn1&phones='.Employee::where('email',$request->email)->first()->tel.'&mes=Код авторизации: '.$code);
            Employee::where('email', $request->email)->update(['code' => $code]);


            return true;
        }else {
            return false;
        }
    }

    public function isgetcode(Request $request)
    {
        /// Employee::where('email', $request->email)->update(['code' => 123]); exit;
        $code = rand(1111,9999);
//dd(Employee::where('email',$request->email)->whereDate('online_user', '>', date('Y-m-d', (time()-(86400*5))))->count());
        if(@Employee::where('email',$request->email)->whereDate('online_user', '<', date('Y-m-d', (time()-(86400*5))))->count()>0) {
            Employee::where('email', $request->email)->update(['code' => $code]);
            $details = [
                'title' => 'Код авторизации',
                'body' => 'Код авторизации: '.$code
            ];


            if(strpos($request->email,"@")){

                Mail::to($request->email)->send(new Sendmail($details));
                return false;
            }else {
                return $code;
            }





        }else {
            return $code;
        }
    }
}
