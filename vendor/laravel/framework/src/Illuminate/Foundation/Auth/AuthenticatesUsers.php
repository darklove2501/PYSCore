<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Cache;

trait AuthenticatesUsers
{
    use RedirectsUsers;

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(\Request $req)
    {
        $request = \Request::all();
        \Debugbar::disable();
        $v = \Validator::make($request, [
            'email' => 'required',
            'password' => 'required'
        ], array(
            'email.required' => 'Yêu cầu nhập tên đăng nhập',
            'password.required' => 'Bạn chưa nhập mật khẩu'
        ));
        $request = \Request::all();

        if($v->fails()) {
            return redirect('auth/login');
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
//        $throttles = $this->isUsingThrottlesLoginsTrait();
//
//        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
//            return $this->sendLockoutResponse($request);
//        }
        //$credentials = $this->getCredentials($req);
        $credentials = array(
            'email' => $request['email'],
            'password' => $request['password']
        );
        if (Auth::attempt($credentials, true)) {
            //return $this->handleUserWasAuthenticated($request, $throttles);
            return redirect('/');
        }
        return redirect('auth/login');

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
//        if ($throttles) {
//            $this->incrementLoginAttempts($request);
//        }
//
//        return redirect($this->loginPath())
//            ->withInput($request->only($this->loginUsername(), 'remember'))
//            ->withErrors([
//                $this->loginUsername() => $this->getFailedLoginMessage(),
//            ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }



    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }
}
