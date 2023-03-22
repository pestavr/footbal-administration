<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Events\Frontend\Auth\UserRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Models\Backend\referees;
use App\Models\Backend\observer;
use App\Models\Backend\teamsAccountable;
/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        // Where to redirect users after registering
        $this->redirectTo = route(homeRoute());

        $this->user = $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('frontend.auth.register');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showObserverRegistrationForm()
    {
        return view('frontend.auth.registerObserver');
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTeamManagerRegistrationForm()
    {
        return view('frontend.auth.registerTeamManager');
    }

    /**
     * @param RegisterRequest $request
     *Register Referee
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(RegisterRequest $request)
    {
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            if (referees::where('tel','=', $request->only('mobile'))->exists()){
                $user = $this->user->create($request->only('first_name', 'last_name', 'email', 'password', 'mobile'), 3);
                event(new UserRegistered($user));
                $referee=referees::where('tel','=',$request->mobile)
                                 ->update(['email'=>$request->email]);
                return redirect($this->redirectPath())->withFlashSuccess(
                config('access.users.requires_approval') ?
                    trans('exceptions.frontend.auth.confirmation.created_pending') :
                    trans('exceptions.frontend.auth.confirmation.created_confirm')
                );
            }else{
                return redirect($this->redirectPath())->withFlashDanger(
                trans('Το τηλέφωνό σας δεν υπάρχει στην βάση μας. Παρακαλώ επικοινωνήστε με τα γραφεία μας')
                );
            }   

            
        } else {
            access()->login($this->user->create($request->only('first_name', 'last_name', 'email', 'password', 'mobile'), 3));
            event(new UserRegistered(access()->user()));

            return redirect($this->redirectPath());
        }
    }

    /**
     * @param RegisterRequest $request
     *Register Observer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function registerObserver(RegisterRequest $request)
    {
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            if (config('settings.observer')){
                if (observer::where('waTel','=', $request->only('mobile'))->exists()){
                    $user = $this->user->create($request->only('first_name', 'last_name', 'email', 'password', 'mobile'), 6);
                    event(new UserRegistered($user));
                    $observer=observer::where('waTel','=',$request->mobile)
                                     ->update(['email'=>$request->email]);
                    return redirect($this->redirectPath())->withFlashSuccess(
                    config('access.users.requires_approval') ?
                        trans('exceptions.frontend.auth.confirmation.created_pending') :
                        trans('exceptions.frontend.auth.confirmation.created_confirm')
                    );
                }else{
                    return redirect($this->redirectPath())->withFlashDanger(
                    trans('Το τηλέφωνό σας δεν υπάρχει στην βάση μας. Παρακαλώ επικοινωνήστε με τα γραφεία μας')
                    );
                }   
            }else{
                return redirect($this->redirectPath())->withFlashDanger(
                trans('Δεν έχετε δικαίωμα εγγραφής')
                );
            }        
            
        } else {
            access()->login($this->user->create($request->only('first_name', 'last_name', 'email', 'password', 'mobile'), 6));
            event(new UserRegistered(access()->user()));

            return redirect($this->redirectPath());
        }
    }

    /**
     * @param RegisterRequest $request
     *Register Observer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function registerTeamManager(RegisterRequest $request)
    {
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            if (config('settings.teamManager')){    
                $user = $this->user->create($request->only('first_name', 'last_name', 'email', 'password', 'mobile'), 7);
                event(new UserRegistered($user));
                $teamsAccountable= new teamsAccountable;
                $teamsAccountable->Name=$request->first_name;
                $teamsAccountable->Surname=$request->last_name;
                $teamsAccountable->email=$request->email;
                $teamsAccountable->Mobile=$request->mobile;
                $teamsAccountable->team_id=$request->team;
                $teamsAccountable->active=1;
                $teamsAccountable->save();
                return redirect($this->redirectPath())->withFlashSuccess(
                config('access.users.requires_approval') ?
                    trans('exceptions.frontend.auth.confirmation.created_pending') :
                    trans('exceptions.frontend.auth.confirmation.created_confirm')
                );
            }else{
                return redirect($this->redirectPath())->withFlashDanger(
                trans('Δεν έχετε δικαίωμα εγγραφής')
                );
            }    
            
        } else {
            access()->login($this->user->create($request->only('first_name', 'last_name', 'email', 'password', 'mobile'), 7));
            event(new UserRegistered(access()->user()));

            return redirect($this->redirectPath());
        }
    }
}
